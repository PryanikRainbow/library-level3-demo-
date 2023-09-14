<?php

namespace Components;

require __DIR__ . '/../vendor/autoload.php';

class Router
{
    protected static $controllers;
    protected static $routes = [];
    const NAMESPACE_CONTROLLERS = 'App\\Controllers\\';

    public function __construct() {
        self::$controllers = new InstancesClasses([
            self::NAMESPACE_CONTROLLERS . 'UserController',
            self::NAMESPACE_CONTROLLERS .'AdminController',
        ]);
    }

    public static function addRoute($method, $path, $controller, $action)
    {
        self::$routes[] = new Route($method, $path, $controller, $action);
    }

    public static function route($requestURI, $requestMethod)
    {
        try {
            foreach (self::$routes as $route) {
                if ($route->queryRoute($route->path, $requestURI) && $route->method === $requestMethod ||
                    $route->simpleRoute($route->path, $requestURI) && $route->method === $requestMethod) {
                    $controller = self::$controllers->getInstance(self::NAMESPACE_CONTROLLERS . $route->controller);
                    $action = $route->action;

                    if ($controller !== null) {
                        if (method_exists($controller, $action)) {
                            return $controller->$action($route->params);
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            echo "(";
            http_response_code(500);
            exit();
            echo ("8");
        }
    }
}
