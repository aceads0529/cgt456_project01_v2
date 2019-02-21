<?php

class Request
{
    private $action, $data;

    /**
     * Request constructor.
     * @param string $action
     * @param array $data
     */
    public function __construct($action, $data = array())
    {
        $this->action = $action;
        $data = $data ? $data : array();

        $this->data = array();

        foreach ($data as $key => $value) {
            if ($value === null)
                continue;

            $this->data[$key] = $value;
        }
    }

    /**
     * @return Request
     */
    public static function from_global()
    {
        $action = isset($_GET['action']) ? $_GET['action'] : null;
        return new Request($action, $_POST);
    }

    /**
     * @return string
     */
    public function get_action()
    {
        return $this->action;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get_param($key)
    {
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }

    /**
     * @param string[] ...$keys
     * @return array
     */
    public function get_params(...$keys)
    {
        if (sizeof($keys) === 0)
            return $this->data;

        $result = array();

        foreach ($keys as $k) {
            $result[$k] = $this->get_param($k);
        }

        return $result;
    }
}