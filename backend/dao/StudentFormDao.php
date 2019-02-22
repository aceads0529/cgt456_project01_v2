<?php
include_once __DIR__ . '\..\includes.php';

class StudentFormDao extends EntityDao
{
    protected static $instance;

    /**
     * @return StudentFormDao
     */
    public static function get_instance()
    {
        /** @var StudentFormDao $instance */
        $instance = parent::get_instance();
        return $instance;
    }

    /**
     * @param int[]|string[] ...$ids
     * @return bool
     */
    function select(...$ids)
    {
        return false;
    }

    /**
     * @param int $work_session_id
     * @param int $student_id
     * @return bool|StudentForm
     */
    function select_form($work_session_id, $student_id)
    {
        if ($rows = $this->conn->query('SELECT * FROM form_student WHERE work_session_id = ? AND student_id = ?', [$work_session_id, $student_id])) {
            return StudentForm::from_array($rows[0]);
        } else {
            return false;
        }
    }

    /**
     * @param int $work_session_id
     * @param int $student_id
     * @return bool
     */
    function exists($work_session_id, $student_id)
    {
        return ($rows = $this->conn->query('SELECT work_session_id FROM form_student WHERE work_session_id = ? AND student_id = ?', [$work_session_id, $student_id]))
            && sizeof($rows) > 0;
    }

    /**
     * @param StudentForm $entity
     * @return boolean
     */
    function insert(&$entity)
    {
        return $this->conn->query('INSERT INTO form_student (work_session_id, student_id, rating, form_activities, form_relevant_work, form_difficulties, form_related_to_major, form_wanted_to_learn, form_cgt_changed_mind, form_provided_contacts) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $entity->work_session_id,
                $entity->student_id,
                $entity->rating,
                $entity->form_activities,
                $entity->form_relevant_work,
                $entity->form_difficulties,
                $entity->form_related_to_major,
                $entity->form_wanted_to_learn,
                $entity->form_cgt_changed_mind,
                $entity->form_provided_contacts])
            && $this->conn->affected_rows() > 0;
    }

    /**
     * @param StudentForm $entity
     * @return boolean
     */
    function update($entity)
    {
        $values = $entity->to_array();
        unset($values['work_session_id']);
        unset($values['student_id']);

        $query_str = sprintf('UPDATE form_student SET %s WHERE work_session_id = ? AND student_id = ?', $this->set($values));

        $values = array_values($values);
        $values[] = $entity->work_session_id;
        $values[] = $entity->student_id;

        return $this->conn->query($query_str, $values)
            && $this->conn->affected_rows() > 0;
    }

    /**
     * @param int|string ...$ids
     * @return boolean
     */
    function delete(...$ids)
    {
        return $this->conn->query(sprintf('DELETE FROM form_student WHERE %s', $this->where('work_session_id', $ids)), $ids)
            && $this->conn->affected_rows() > 0;
    }
}
