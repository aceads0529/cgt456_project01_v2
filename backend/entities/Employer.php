<?php
include_once __DIR__ . '\..\includes.php';

class Employer extends Entity
{
    public $name, $address, $search_str, $cgt_field_ids;

    /**
     * @return EmployerDao
     */
    public static function dao()
    {
        return new EmployerDao('employer', 'Employer');
    }
}