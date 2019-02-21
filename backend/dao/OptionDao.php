<?php
include_once __DIR__ . '\..\includes.php';

class OptionDao extends Dao
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
        return $this->conn->query('SELECT id, label FROM cgt_field ORDER BY sort_order ASC');
    }

    /**
     * @return array|bool
     */
    public function get_financial_asst()
    {
        return $this->conn->query('SELECT id, label FROM financial_asst ORDER BY sort_order ASC');
    }
}
