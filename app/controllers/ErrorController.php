<?php

namespace app\controllers;
require_once 'Controller.php';

class ErrorController extends Controller
{
    public static function printErrorPage()
    {
        echo "error";
        // echo json_encode(['error' => 'Bad Request']);
        // http_response_code(404);
       render( __DIR__ . '/../../views/error.php');
    }
}
