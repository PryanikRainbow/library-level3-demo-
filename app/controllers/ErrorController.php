<?php

namespace app\controllers;

require_once 'Controller.php';

class ErrorController
{
    public function printErrorPage()
    {
        echo "error";
        // echo json_encode(['error' => 'Bad Request']);
        // http_response_code(404);
        require_once __DIR__ . '/../../views/error.php';
    }
}
