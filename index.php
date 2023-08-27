<?php

// use App\Controllers\SearchController;
// use Includes\RouteHelper;

require __DIR__ . '/vendor/autoload.php';


// use App\Controllers\UserController;
// use App\Controllers\SearchController;
// use App\Controllers\ErrorController;
// use Includes\RouteHelper;  

// use App\Controllers\UserController;
// require_once __DIR__.'/app/controllers/UserController.php';
// require_once 'app/controllers/UserController.php';
// require_once 'app/controllers/SearchController.php';
// require_once 'app/controllers/ErrorController.php';

// require_once 'app/controllers/AdminController.php';

// use app\controllers\UserController; 
// use app\controllers\SearchController; 
// use app\controllers\ErrorController; 

const EXPECTED_BOOKS_TEMPLATE = 'books-page';
const EXPECTED_BOOK_TEMPLATE = 'book-page';
const EXPECTED_ERROR_TEMPLATE = 'error';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$requestURI = $_SERVER ['REQUEST_URI' ];
$userController = new \App\Controllers\UserController;
$searchController = new \App\Controllers\SearchController;
$errorController = new \App\Controllers\ErrorController;
$route = new \Includes\RouteHelper; 

// $router = new \Includes\Router;
// $currentRoute = $router->match($requestURI);

// if ($currentRoute) {
//     $action = $currentRoute->action;
//     $params = $currentRoute->params;

//     $userController->defineController($action, $p);
// }

// if ("/" === $requestURI) {
//     $userController->defineController("printBooks", 0);
// }

// $requestURI = '/counter/';


//потім щось треба придумати, коли додасться delete

if ($route::simpleRoute("/", $requestURI)) {
    $userController->defineController($route::getObject(),  ["offset" => 0] );
}
elseif ($route::simpleRoute('/counter/', $requestURI)) {
    $userController->defineController($route::getObject());
}
elseif ($route::simpleRoute("/book/", $requestURI) && $route::isNumParam()) {
    $userController->defineController($route::getObject(), $route::getParams());
}
 elseif($route::queryRoute($requestURI) && $route::isUserController()){
    $object = $route::getObject();

    $userController->defineController($route::getObject(), $route::getParams());
}
//elseif($route::simpleRoute("/search/by-title/", $requestURI) ){
//     $searchController->defineController("/search/by-title/",$route::getParam());
// } elseif($requestURI === '/views/error.php'){
//     echo "views error";
//     $errorController::printErrorPage();
// } elseif($requestURI === '/admin/a.php'){
//    require_once __DIR__.'/app/controllers/AdminController.php';
// }
else {
    echo 'else';
    $errorController->printErrorPage();
}

// elseif(route("/offset/", $requestURI) && isNumParam()){
// }
// elseif(route("/offset/next/", $requestURI) && isNumParam()){
//     echo(getParam());
//      echo "next";
//    $userController->defineController(BOOKS_PAGE, (int)getParam());
// } elseif(route("/offset/prev/", $requestURI) && isNumParam()){
//     echo "prev";
//    $userController->defineController(BOOKS_PAGE, (int)getParam());
// }


const EXISTED_DIRS_PATHS =
[
     "/views/",
     "/views/books-page.php",
     "/views/book-page.php"
 ];



