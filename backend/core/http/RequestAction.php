<?php

class RequestAction
{
    private $action, $callback, $required_fields;

    public function __construct($action, $callback, $required_fields = array())
    {
        $this->action = $action;
        $this->callback = $callback;
        $this->required_fields = $required_fields;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function __invoke($request)
    {
        if ($missing = $this->get_missing_params($request)) {
            return new Response(false, sprintf('API missing parameters: [%s]', implode(', ', $missing)));
        } else {
            if ($c = $this->callback)
                return $c($request);
            else
                return new Response(false, 'API action callback undefined');
        }
    }

    /**
     * @param string[] ...$fields
     * @return RequestAction
     */
    public function requires(...$fields)
    {
        $this->required_fields = $fields;
        return $this;
    }

    /**
     * @param callable $callback
     * @return RequestAction
     */
    public function callback($callback)
    {
        $this->callback = $callback;
        return $this;
    }

    /**
     * @param Request $request
     * @return array
     */
    private function get_missing_params($request)
    {
        $params = call_user_func_array([$request, 'get_params'], $this->required_fields);
        $missing = array();

        foreach ($params as $key => $p) {
            if ($p === null)
                $missing[] = $key;
        }

        return $missing;
    }
}