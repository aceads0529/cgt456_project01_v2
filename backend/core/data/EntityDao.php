<?php
include_once __DIR__ . '\Entity.php';
include_once __DIR__ . '\DaoConnection.php';
include_once __DIR__ . '\DaoQuery.php';

class EntityDao
{
    private $table, $class;
    protected $conn;

    /**
     * EntityDao constructor.
     * @param string $table
     * @param string $class
     */
    public function __construct($table, $class)
    {
        $this->table = $table;
        $this->class = $class;
        $this->conn = DaoConnection::default_conn();
    }

    /**
     * @param Entity $entity
     * @return bool|array
     */
    function select($entity)
    {
        $rows = $this->conn->execute(
            (new DaoQuery(DaoQuery::SELECT))
                ->tables($this->table)
                ->where($entity)
        );

        if ($rows) {
            foreach ($rows as &$row) {
                $row = new $this->class($row);
            }
        }

        return $rows;
    }

    /**
     * @param string $prop
     * @param mixed $value
     * @return bool|array
     */
    function select_by($prop, $value)
    {
        $obj = new $this->class([$prop => $value]);
        return $this->select($obj);
    }

    /**
     * @param Entity $entity
     * @return bool
     */
    public function insert(&$entity)
    {
        $cols = array_keys($entity->to_db_array(false));

        $this->conn->execute(
            (new DaoQuery(DaoQuery::INSERT))
                ->tables($this->table)
                ->columns($cols)
                ->values($entity)
        );

        if ($this->conn->affected_rows() > 0) {
            $entity->id = $this->conn->insert_id();
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param Entity $entity
     * @return bool
     */
    public function delete($entity)
    {
        $this->conn->execute(
            (new DaoQuery(DaoQuery::DELETE))
                ->tables($this->table)
                ->where($entity)
        );

        return $this->conn->affected_rows() > 0;
    }
}