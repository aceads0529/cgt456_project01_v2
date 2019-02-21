<?php

class StudentForm extends Entity
{
    public $work_session_id,
        $student_id,
        $rating,
        $form_activities,
        $form_relevant_work,
        $form_difficulties,
        $form_related_to_major,
        $form_wanted_to_learn,
        $form_cgt_changed_mind,
        $form_provided_contacts;

    public function __construct($work_session_id = null,
                                $student_id = null,
                                $rating = null,
                                $form_activities = null,
                                $form_relevant_work = null,
                                $form_difficulties = null,
                                $form_related_to_major = null,
                                $form_wanted_to_learn = null,
                                $form_changed_mind = null,
                                $form_provided_contacts = null)
    {
        $this->work_session_id = $work_session_id;
        $this->student_id = $student_id;
        $this->rating = $rating;
        $this->form_activities = $form_activities;
        $this->form_relevant_work = $form_relevant_work;
        $this->form_difficulties = $form_difficulties;
        $this->form_related_to_major = $form_related_to_major;
        $this->form_wanted_to_learn = $form_wanted_to_learn;
        $this->form_cgt_changed_mind = $form_changed_mind;
        $this->form_provided_contacts = $form_provided_contacts;
    }
}
