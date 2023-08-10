<?php

// require_once __DIR__.'/app/controllers/UserController.php';
require_once 'app/controllers/UserController.php';
require_once 'app/controllers/ErrorController.php';
require_once 'includes/requestBookChecking.php';
// require_once 'app/controllers/AdminController.php';

use app\controllers\UserController; 
use app\controllers\ErrorController; 

const BOOKS_PAGE = 'books-page.php';
const BOOK_PAGE = 'book-page.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$requestURI = $_SERVER ['REQUEST_URI' ];
$userController = new UserController;

///views/book-page.php?id=1
if ($requestURI === "/") {
   $userController->defineController(BOOKS_PAGE,0);
} elseif(route("/views/book-page.php?id=", $requestURI) && isNumParam()){
    //початк урі, гет передаємл
   $userController->defineController('book-page.php', (int)getParam());
} elseif(route("/offset/next/", $requestURI) && isNumParam()){
    echo(getParam());
    // echo "next";
   $userController->defineController(BOOKS_PAGE, (int)getParam());
} elseif(route("/offset/prev/", $requestURI) && isNumParam()){
    echo "prev";
   $userController->defineController(BOOKS_PAGE, (int)getParam());
} elseif($requestURI === '/views/error.php'){
    echo "views error";
    ErrorController::printErrorPage();
} elseif($requestURI === '/admin/a.php'){
   require_once __DIR__.'/app/controllers/AdminController.php';
}
else {
    echo 'else';
    $errorController = new ErrorController('error.php');
    $errorController -> printErrorPage();
}


const EXISTED_DIRS_PATHS =
[
     "/views/",
     "/views/books-page.php",
     "/views/book-page.php"
 ];



