<?php
include_once __DIR__ . '\..\includes.php';

class Employer
{
    public $id, $name, $address, $cgt_field_ids;

    /**
     * Employer constructor.
     * @param int $id
     * @param string $name
     * @param string $address
     * @param string[] $cgt_field_ids
     */
    public function __construct($id = null, $name = null, $address = null, $cgt_field_ids = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->address = $address;
        $this->cgt_field_ids = $cgt_field_ids;
    }

    /**
     * @return string
     */
    public function get_search_str()
    {
        return preg_replace('/[^a-z]/', '', strtolower($this->name));
    }
}
