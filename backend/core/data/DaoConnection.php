<?php

class DaoConnection
{
    private $host, $username, $password, $db;
    private $conn, $affected_rows;

    public function __construct($host, $username, $password, $db)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->db = $db;

        $this->affected_rows = 0;

        $this->conn = new mysqli($host, $username, $password, $db);
    }

    /**
     * @return DaoConnection
     */
    public static function default_host()
    {
        include_once __DIR__ . '\..\..\environment.php';
        return new DaoConnection(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }

    /**
     * @param string $query_str
     * @param array $params
     * @return PDOStatement
     * @throws Exception
     */
    public function pdo_execute($query_str, $params)
    {
        $pdo = new PDO('mysql:host=localhost:3306;dbname=cgt456_project01', 'root', '');
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $stmt = $pdo->prepare($query_str);

        if (!$stmt) {
            throw new Exception(sprintf('Invalid query "%s"', $query_str));
        }

        foreach ($params as $key => $value) {
            if (!$this->bind_param($stmt, $key, $value)) {
                throw new Exception(sprintf('Invalid parameter "%s" in query', $key));
            }
        }

        if (!$stmt->execute()) {
            throw new Exception($stmt->errorInfo()[2]);
        }

        return $stmt;
    }

    /**
     * @param PDOStatement $stmt
     * @param string $name
     * @param mixed $value
     * @return bool
     */
    private function bind_param($stmt, $name, &$value)
    {
        $type = null;

        if (is_int($value)) {
            $type = PDO::PARAM_INT;
        } else if (is_string($value)) {
            $type = PDO::PARAM_STR;
        } else if (is_bool($value)) {
            $value = $value ? 1 : 0;
            $type = PDO::PARAM_INT;
        } else if (is_float($value)) {
            $value = strval($value);
            $type = PDO::PARAM_STR;
        }

        if ($type) {
            $stmt->bindParam(':' . $name, $value, $type);
        }

        return $type ? true : false;
    }

    /**
     * @param string $query_str
     * @param array $params
     * @return bool|array
     */
    public function query($query_str, $params = null)
    {
        $this->affected_rows = 0;
        $stmt = $this->conn->prepare($query_str);

        if (!$stmt)
            return false;

        if ($params) {
            $type_str = '';

            foreach ($params as &$v) {
                if (is_integer($v)) {
                    $type_str .= 'i';
                } elseif (is_bool($v)) {
                    $type_str .= 'i';
                    $v = $v ? 1 : 0;
                } elseif (is_double($v)) {
                    $type_str .= 'd';
                } elseif (is_string($v)) {
                    $type_str .= 's';
                } elseif (is_object($v)) {
                    $type_str .= 's';
                    $v = (string)$v;
                } else {
                    $type_str .= 'i';
                    $v = null;
                }
            }

            array_unshift($params, $type_str);
            call_user_func_array(array($stmt, 'bind_param'), $params);
        }

        if (!$stmt->execute()) {
            return false;
        }

        $this->affected_rows = $stmt->affected_rows;

        if ($result = $stmt->get_result()) {
            $rows = array();

            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }

            return $rows;
        } else {
            return true;
        }
    }

    /**
     * @return int|string
     */
    public function insert_id()
    {
        return mysqli_insert_id($this->conn);
    }

    /**
     * @return int
     */
    public function affected_rows()
    {
        return $this->affected_rows;
    }
}
