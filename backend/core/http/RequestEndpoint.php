<?php
include_once __DIR__ . '\Request.php';
include_once __DIR__ . '\Response.php';
include_once __DIR__ . '\RequestAction.php';
include_once __DIR__ . '\..\Debug.php';

class RequestEndpoint
{
    private $actions;

    public function __construct()
    {
        $this->actions = array();
    }

    /**
     * @param string $action
     * @param callable $callback
     * @return RequestAction
     */
    public function action($action, $callback = null)
    {
        $a = new RequestAction($action, $callback);
        $this->actions[$action] = $a;

        return $a;
    }

    /**
     * @param Request $request
     */
    public function call($request = null)
    {
        try {
            if ($request === null) {
                $request = Request::from_global();
            }

            Debug::log(sprintf('API call to "%s/%s"', Debug::get_script_dir(), $request->get_action()));

            $a = $request->get_action();

            if (isset($this->actions[$a])) {
                $response = $this->actions[$a]($request);
            } else {
                $response = new Response(false, 'Invalid action');
            }

            $response->echo();
        } catch (ResponseException $e) {
            $e->getResponse()->echo();
        } catch (Exception $e) {
            Response::error_server()->echo();
        }
    }
}