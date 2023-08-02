<?php

namespace app\controllers;

class Controller
{
    private static $instancesControllers = [];

    public function __construct()
    {
    }

    protected function __clone()
    {
    }

    public function __wakeup()
    {
    }

    private function __sleep()
    {
    }

    public static function getInstance()
    {
        $controller = static::class;
        if (!isset(self::$instancesControllers[$controller])) {
            self::$instancesControllers[$controller] = new static();
        }
    }

}
