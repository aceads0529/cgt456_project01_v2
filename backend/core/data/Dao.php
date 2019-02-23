<?php

class Dao
{
    private static $instance;

    /**
     * @return Dao
     */
    public static function get_instance()
    {
        if (static::$instance === null) {
            $class = get_called_class();
            static::$instance = new $class();
        }
        return static::$instance;
    }

    protected $conn;

    public function __construct()
    {
        $this->conn = DaoConnection::default_host();
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return string
     */
    protected function where($key, $value)
    {
        if (is_array($value)) {
            $qmarks = array_fill(0, sizeof($value), '?');
            $qmarks = implode(',', $qmarks);
            return sprintf('%s IN (%s)', $key, $qmarks);
        } else {
            return sprintf('%s = ?', $key);
        }
    }

    protected function set($values)
    {
        $clauses = array();
        foreach ($values as $key => $value) {
            $clauses[] = $key . ' = ?';
        }
        return implode(', ', $clauses);
    }
}
