<?php
include_once __DIR__ . '\..\includes.php';

class EmployerDao extends EntityDao
{
    protected static $instance;

    /**
     * @return EmployerDao
     */
    public static function get_instance()
    {
        /** @var EmployerDao $instance */
        $instance = parent::get_instance();
        return $instance;
    }

    /**
     * @param int[]|string[] $ids
     * @return Employer[]|bool
     */
    public function select(...$ids)
    {
        $query_str =
            'SELECT E.*, GROUP_CONCAT(EF.cgt_field_id) as cgt_field_ids ' .
            'FROM employer E, employer_cgt_fields EF ' .
            'WHERE E.id = EF.employer_id AND ' . $this->where('E.id', $ids) .
            ' GROUP BY E.id';

        if ($rows = $this->conn->query($query_str, $ids)) {
            $result = array();
            foreach ($rows as $row) {
                $row['cgt_field_ids'] = explode(',', $row['cgt_field_ids']);
                $result[] = Employer::from_array($row);
            }
            return $result;
        } else {
            return false;
        }
    }

    /**
     * @param Employer $entity
     * @return bool
     */
    public function insert(&$entity)
    {
        $query_str = 'INSERT INTO employer (name, address, search_str) VALUES (?, ?, ?)';

        if ($this->conn->query($query_str, [$entity->name, $entity->address, self::get_search_str($entity->name)])
            && $this->conn->affected_rows() > 0) {

            $entity->id = $this->conn->insert_id();
            $query_str = 'INSERT IGNORE INTO employer_cgt_fields (employer_id, cgt_field_id) VALUES (?, ?)';

            foreach ($entity->cgt_field_ids as $field) {
                $this->conn->query($query_str, [$entity->id, $field]);
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param Entity $entity
     * @return boolean
     */
    public function update($entity)
    {
        $values = $entity->to_array();
        unset($values['id']);

        $query_str = sprintf('UPDATE employer SET %s WHERE id = ?', $this->set($values));

        $values = array_values($values);
        $values[] = $entity->id;

        return $this->conn->query($query_str, $values);
    }

    /**
     * @param int[]|string[] $ids
     * @return bool
     */
    public function delete(...$ids)
    {
        $query_str = 'DELETE FROM employer WHERE ' . $this->where('id', $ids);
        return $this->conn->query($query_str, $ids) && $this->conn->affected_rows() > 0;
    }

    /**
     * @param string $name
     * @return Entity[]|bool
     */
    public function search($name)
    {
        $name = '%' . self::get_search_str($name) . '%';
        $query_str =
            'SELECT E.*, GROUP_CONCAT(EF.cgt_field_id) as cgt_field_ids ' .
            'FROM employer E, employer_cgt_fields EF ' .
            'WHERE E.id = EF.employer_id AND E.search_str LIKE ? ' .
            'GROUP BY E.id';

        if ($rows = $this->conn->query($query_str, [$name])) {
            $result = array();
            foreach ($rows as $row) {
                $row['cgt_field_ids'] = explode(',', $row['cgt_field_ids']);
                $result[] = Employer::from_array($row);
            }
            return $result;
        } else {
            return false;
        }
    }

    /**
     * @param string $name
     * @return string
     */
    public static function get_search_str($name)
    {
        return preg_replace('/[^a-z]/', '', strtolower($name));
    }
}
