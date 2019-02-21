<?php
include_once __DIR__ . '\..\includes.php';

/**
 * Class Employer
 * @method static EmployerDao dao()
 */
class Employer extends Entity
{
    public $name, $address, $cgt_field_ids;

    public function __construct($id = null, $name = null, $address = null, $cgt_field_ids = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->address = $address;
        $this->cgt_field_ids = $cgt_field_ids;
    }
}