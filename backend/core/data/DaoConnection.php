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
    public static function default_conn()
    {
        return new DaoConnection('www.aaroneads.com:3306', 'admin', 'Ascii32', 'cgt456_project01');
    }

    /**
     * @param string $query_str
     * @param array $params
     * @param bool $flatten
     * @return bool|array
     */
    public function query($query_str, $params = null, $flatten = false)
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

            if ($flatten === true) {
                $rows = DaoQuery::array_flatten($rows);
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
