<?php

class SupervisorForm
{
    public $work_session_id,
        $supervisor_id,
        $rate_dependable,
        $rate_cooperative,
        $rate_interested,
        $rate_fast_learner,
        $rate_initiative,
        $rate_work_quality,
        $rate_responsibility,
        $rate_criticism,
        $rate_organization,
        $rate_tech_knowledge,
        $rate_judgement,
        $rate_creativity,
        $rate_problem_analysis,
        $rate_self_reliance,
        $rate_communication,
        $rate_writing,
        $rate_prof_attitude,
        $rate_prof_appearance,
        $rate_punctual,
        $rate_time_effective;

    public function __construct($work_session_id = null,
                                $supervisor_id = null,
                                $rate_dependable = null,
                                $rate_cooperative = null,
                                $rate_interested = null,
                                $rate_fast_learner = null,
                                $rate_initiative = null,
                                $rate_work_quality = null,
                                $rate_responsibility = null,
                                $rate_criticism = null,
                                $rate_organization = null,
                                $rate_tech_knowledge = null,
                                $rate_judgement = null,
                                $rate_creativity = null,
                                $rate_problem_analysis = null,
                                $rate_self_reliance = null,
                                $rate_communication = null,
                                $rate_writing = null,
                                $rate_prof_attitude = null,
                                $rate_prof_appearance = null,
                                $rate_punctual = null,
                                $rate_time_effective = null)
    {
        $this->work_session_id = $work_session_id;
        $this->supervisor_id = $supervisor_id;
        $this->rate_dependable = $rate_dependable;
        $this->rate_cooperative = $rate_cooperative;
        $this->rate_interested = $rate_interested;
        $this->rate_fast_learner = $rate_fast_learner;
        $this->rate_initiative = $rate_initiative;
        $this->rate_work_quality = $rate_work_quality;
        $this->rate_responsibility = $rate_responsibility;
        $this->rate_criticism = $rate_criticism;
        $this->rate_organization = $rate_organization;
        $this->rate_tech_knowledge = $rate_tech_knowledge;
        $this->rate_judgement = $rate_judgement;
        $this->rate_creativity = $rate_creativity;
        $this->rate_problem_analysis = $rate_problem_analysis;
        $this->rate_self_reliance = $rate_self_reliance;
        $this->rate_communication = $rate_communication;
        $this->rate_writing = $rate_writing;
        $this->rate_prof_attitude = $rate_prof_attitude;
        $this->rate_prof_appearance = $rate_prof_appearance;
        $this->rate_punctual = $rate_punctual;
        $this->rate_time_effective = $rate_time_effective;
    }
}
