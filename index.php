<?php

require __DIR__ . '/vendor/autoload.php';

const EXPECTED_BOOKS_TEMPLATE = 'books-page';
const EXPECTED_BOOK_TEMPLATE = 'book-page';
const EXPECTED_ERROR_TEMPLATE = 'error';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$requestURI = $_SERVER ['REQUEST_URI' ];
$userController = new \App\Controllers\UserController();
$errorController = new \App\Controllers\ErrorController();
$adminController = new \App\Controllers\AdminController();
$route = new \Includes\RouteHelper();

// require( __DIR__ . '/admin/views/header.php');
// require(__DIR__ . '/admin/views/admin-page.php');
// require(__DIR__ . '/admin/views/test.php');

// echo require( __DIR__ . '/admin/views/admin-books-page_test.php');


//спочатку query? норм
if ($route::simpleRoute("/", $requestURI)) {
    $userController->defineController($route::getObject(), ["offset" => 0]);
} elseif ($route::simpleRoute('/counter/', $requestURI)) {
    $userController->defineController($route::getObject());
} elseif ($route::simpleRoute("/book/", $requestURI) && $route::isNumParam()) {
    $userController->defineController($route::getObject(), $route::getParams());
} elseif($route::queryRoute($requestURI) && $route::isUserController()) {
    $object = $route::getObject();

    $userController->defineController($route::getObject(), $route::getParams());
}   
elseif($route::queryRoute($requestURI) && $route::isAdminController()) {
    // echo "query";
    $adminController->defineController($route::getObject(), $route::getParams());

} 
elseif($route::simpleRoute("/admin/page/", $requestURI)) {
    // echo "simple+off";
    // var_dump($route::getParams());
    $adminController->defineController($route::getObject(), ["page" => 1]);
}
else {
    http_response_code(404);
    $errorController->defineController($route::ERROR_OBJS[0]);
}
