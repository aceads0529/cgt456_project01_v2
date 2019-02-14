<?php

class ResponseException extends Exception
{
    private $response;

    /**
     * ResponseException constructor.
     * @param Response $response
     * @param Throwable $previous
     */
    public function __construct($response, $previous = null)
    {
        $this->response = $response;
        parent::__construct($response->message, $response->success ? 0 : 1, $previous);
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }
}