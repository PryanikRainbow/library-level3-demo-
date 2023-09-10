<?php

namespace App\Controllers;
require __DIR__ . '/../../vendor/autoload.php';

class ErrorController extends Controller
{  
      public function defineController($obj, $params = null)
    {
        $action = "print$obj";
        return method_exists($this, $action)
            ? $this->$action($action, $params)
            : self::printError();
    }

    private static function printError()
    {
       render( __DIR__ . '/../../views/error.php');
    }
}
