<?php
include_once __DIR__ . '\Entity.php';
include_once __DIR__ . '\DaoConnection.php';
include_once __DIR__ . '\DaoQuery.php';

abstract class EntityDao
{
    private static $instance;

    /**
     * @return EntityDao
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
        $this->conn = DaoConnection::default_conn();
    }

    /**
     * @param Entity $entity
     * @param array $row
     * @return Entity
     */
    protected function populate_entity(&$entity, $row)
    {
        foreach ($row as $key => $value) {
            if (property_exists($entity, $key)) {
                $entity->{$key} = $value;
            }
        }
        return $entity;
    }

    /**
     * @param Entity $entity
     * @return array
     */
    protected function filter_entity($entity)
    {
        $result = array();
        foreach ($entity as $key => $value) {
            if ($entity->{$key} !== null) {
                $result[$key] = $value;
            }
        }
        return $result;
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
            $qmakrs = implode(',', $qmarks);
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