<?php

class Response
{
    public $success, $message, $data;

    /**
     * Response constructor.
     * @param bool $success
     * @param string $message
     * @param array $data
     */
    public function __construct($success = true, $message = '', $data = null)
    {
        $this->success = $success;
        $this->message = $message;
        $this->data = $data;
    }

    /**
     * @param bool $exit
     */
    public function echo($exit = true)
    {
        header('Content-Type: application/json');
        $body = Response::deep_json_encode($this);

        echo $body;

        if ($exit)
            exit;
    }

    /**
     * @param mixed $data
     * @return false|string
     */
    private static function deep_json_encode($data)
    {
        if (is_object($data)) {
            $new_arr = array();

            foreach ($data as $key => $value) {
                $new_arr[$key] = $value;
            }

            $data = $new_arr;
        }

        return json_encode($data);
    }

    /**
     * @return Response
     */
    public static function error_server()
    {
        return new Response(false, 'Internal server error');
    }

    /**
     * @return Response
     */
    public static function error_permission()
    {
        return new Response(false, 'Permission denied');
    }
}