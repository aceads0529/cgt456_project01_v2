<?php

class RequestPermissions
{
    private $permissions;

    public function __construct(...$allowed)
    {
        $this->permissions = $allowed;
    }

    public function allow($action)
    {
        if (!in_array($action, $this->permissions)) {
            $permissions[] = $action;
        }
    }

    public function is_permitted($action)
    {
        $split = explode('/', $action);
        return in_array($action, $this->permissions)
            || sizeof($split === 2) && in_array($split[0] . '/*', $this->permissions)
            || in_array('*', $this->permissions);
    }
}