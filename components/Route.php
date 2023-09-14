<?php

namespace Components;

require __DIR__ . '/../vendor/autoload.php';

class Route
{
    public $method;
    public $path;
    public $controller;
    public $action;
    public $params = [];

    public function __construct($method, $path, $controller, $action)
    {
        $this->method = $method;
        $this->path = $path;
        $this->controller = $controller;
        $this->action = $action;
    }

    public function simpleRoute($pathURI, $requestURI)
    {
        if ($pathURI === $requestURI) {
            return true;
        }
       
        if (strpos($requestURI, $pathURI) === 0 && $pathURI !== "/") {
            $this->params[] = substr($requestURI, strlen($pathURI));
            
            return true;
        }

        return false;
    }

    public function queryRoute($pathURI, $requestURI)
    {
        $parsedUrl = parse_url($requestURI);
        $actionPath = $parsedUrl['path'];

        if (isset($parsedUrl['query']) && $actionPath === $pathURI) {
            parse_str($parsedUrl['query'], $params);
            $this->setParams($params);

            return true;
        }

        return false;
    }

    public function setParams($params)
    {
        $this->params = $params;
    }

    public function getParams()
    {
        return $this->params;
    }
}
