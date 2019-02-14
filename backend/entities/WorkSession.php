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
}