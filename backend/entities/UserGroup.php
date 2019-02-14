<?php
include_once __DIR__ . '\..\includes.php';

class UserGroup extends Entity
{
    public $label;

    /**
     * @return EntityDao
     */
    public static function dao()
    {
        return new EntityDao('user_group', 'UserGroup');
    }
}