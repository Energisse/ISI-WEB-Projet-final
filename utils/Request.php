<?php

class Request
{

    private $controller;
    private $action;
    private $method;

    function __construct(string $controller, string $action, string $method)
    {
        $this->controller = $controller;
        $this->action = $action;
        $this->method = $method;
    }

    static function FromPath(string $path, string $method): Request
    {
        $urlExploded = explode('/', $path, 3); //On separe l'url
        $controller = array_slice($urlExploded, 0, 1)[0]; //on recupere le controller
        $action = "/" . array_slice($urlExploded, 1, 1)[0]; //on recupere l'action
        return new Request($controller, $action, $method);
    }

    /**
     * Get the value of controller
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Get the value of action
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Get the value of method
     */
    public function getMethod()
    {
        return $this->method;
    }
}