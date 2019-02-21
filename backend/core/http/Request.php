<?php

class Request
{
    public $action, $data;

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
    public function get_data($key)
    {
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }

    /**
     * @param string[] ...$keys
     * @return array
     */
    public function get_params(...$keys)
    {
        $result = array();
        foreach ($keys as $key) {
            $result[$key] = isset($this->data[$key]) ? $this->data[$key] : null;
        }
        return $result;
    }
}
