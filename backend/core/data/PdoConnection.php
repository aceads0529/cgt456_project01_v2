<?php

class PdoConnection
{
    private $pdo;
    public $host, $user, $pswd, $schema;

    public function __construct($host, $user, $pswd, $schema)
    {
        $this->host = $host;
        $this->user = $user;
        $this->pswd = $pswd;
        $this->schema = $schema;

        $this->pdo = new PDO(sprintf('mysql:host=%s;dbname=%s', $host, $schema), $user, $pswd);
        $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    /**
     * @param string $query_str
     * @param array $params
     * @return PDOStatement
     * @throws Exception
     */
    public function execute($query_str, $params)
    {
        $stmt = $this->pdo->prepare($query_str);

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
     * @return int|string
     */
    public function last_insert_id()
    {
        $value = $this->pdo->lastInsertId();
        if (is_numeric($value)) {
            return (int)$value;
        } else {
            return $value;
        }
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
}
