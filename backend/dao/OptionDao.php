<?php
include_once __DIR__ . '\..\includes.php';

class OptionDao extends EntityDao
{
    protected static $instance;

    /**
     * @return OptionDao
     */
    public static function get_instance()
    {
        /** @var OptionDao $instance */
        $instance = parent::get_instance();
        return $instance;
    }

    /**
     * @return array|bool
     */
    public function get_cgt_fields()
    {
        return $this->conn->query('SELECT * FROM cgt_field');
    }
}