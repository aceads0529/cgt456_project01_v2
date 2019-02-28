<?php

class SupervisorFormDao extends Dao
{
    protected static $instance;

    /**
     * @return SupervisorFormDao
     */
    public static function get_instance()
    {
        /** @var SupervisorFormDao $instance */
        $instance = parent::get_instance();
        return $instance;
    }


    public function select_form($work_session_id, $supervisor_id)
    {

    }

    /**
     * @param SupervisorForm $entity
     * @return bool
     */
    function insert(&$entity)
    {
        return $this->conn->query('INSERT INTO form_supervisor VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $entity->work_session_id,
                $entity->supervisor_id,
                $entity->rate_dependable,
                $entity->rate_cooperative,
                $entity->rate_interested,
                $entity->rate_fast_learner,
                $entity->rate_initiative,
                $entity->rate_work_quality,
                $entity->rate_responsibility,
                $entity->rate_criticism,
                $entity->rate_organization,
                $entity->rate_tech_knowledge,
                $entity->rate_judgement,
                $entity->rate_creativity,
                $entity->rate_problem_analysis,
                $entity->rate_self_reliance,
                $entity->rate_communication,
                $entity->rate_writing,
                $entity->rate_prof_attitude,
                $entity->rate_prof_appearance,
                $entity->rate_punctual,
                $entity->rate_time_effective])
            && $this->conn->affected_rows() > 0;
    }
}
