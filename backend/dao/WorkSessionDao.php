<?php

class WorkSessionDao extends EntityDao
{
    protected static $instance;

    /**
     * @return WorkSessionDao
     */
    public static function get_instance()
    {
        /** @var WorkSessionDao $instance */
        $instance = parent::get_instance();
        return $instance;
    }

    /**
     * @param string[]|int[] ...$ids
     * @return WorkSession[]|bool
     */
    public function select(...$ids)
    {
        if ($rows = $this->conn->query(sprintf('SELECT * FROM work_session WHERE %s', self::where('id', $ids)), $ids)) {
            $result = array();
            foreach ($rows as $row) {
                $result[] = WorkSession::from_array($row);
            }
            return $result;
        } else {
            return false;
        }
    }

    /**
     * @param int $student_id
     * @return bool|WorkSession[]
     */
    public function select_student($student_id)
    {
        if ($rows = $this->conn->query('SELECT * FROM work_session WHERE student_id = ?', [$student_id])) {
            $result = array();
            foreach ($rows as $row) {
                $result[] = WorkSession::from_array($row);
            }
            return $result;
        } else {
            return false;
        }
    }

    /**
     * @param WorkSession $entity
     * @return bool
     */
    public function insert(&$entity)
    {
        $result = $this->conn->query('INSERT INTO work_session (student_id, supervisor_id, employer_id, job_title, address, start_date, end_date, offsite, total_hours, pay_rate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $entity->student_id,
            $entity->supervisor_id,
            $entity->employer_id,
            $entity->job_title,
            $entity->address,
            $entity->start_date,
            $entity->end_date,
            $entity->offsite,
            $entity->total_hours,
            $entity->pay_rate]);

        if ($result && $this->conn->affected_rows() > 0) {
            $entity->id = $this->conn->insert_id();
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param WorkSession $entity
     * @return bool
     */
    public function update($entity)
    {
        $values = $entity->to_array();
        unset($values['id']);

        $query_str = sprintf('UPDATE work_session SET %s WHERE id = ?', $this->set($values));

        $values = array_values($values);
        $values[] = $entity->id;

        return $this->conn->query($query_str, $values) && $this->conn->affected_rows() > 0;
    }

    /**
     * @param string[]|int[] ...$ids
     * @return bool
     */
    public function delete(...$ids)
    {
        return $this->conn->query(sprintf('DELETE FROM work_session WHERE %s', $this->where('id', $ids)), $ids) && $this->conn->affected_rows() > 0;
    }
}
