<?php
include_once __DIR__ . '\..\includes.php';

class WorkSession extends Entity
{
    public
        $student_id,
        $supervisor_id,
        $employer_id,
        $job_title,
        $address,
        $start_date,
        $end_date,
        $offsite,
        $total_hours,
        $pay_rate;

    public function __construct($id = null,
                                $student_id = null,
                                $supervisor_id = null,
                                $employer_id = null,
                                $job_title = null,
                                $address = null,
                                $start_date = null,
                                $end_date = null,
                                $offsite = null,
                                $total_hours = null,
                                $pay_rate = null)
    {
        $this->id = $id;
        $this->student_id = $student_id;
        $this->supervisor_id = $supervisor_id;
        $this->employer_id = $employer_id;
        $this->job_title = $job_title;
        $this->address = $address;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->offsite = $offsite;
        $this->total_hours = $total_hours;
        $this->pay_rate = $pay_rate;
    }
}
