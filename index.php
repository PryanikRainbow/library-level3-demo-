<?php

// require_once __DIR__.'/app/controllers/UserController.php';
require_once 'app/controllers/UserController.php';
require_once 'app/controllers/ErrorController.php';
// require_once 'app/controllers/AdminController.php';

use app\controllers\UserController; 
use app\controllers\ErrorController; 

error_reporting(E_ALL);
ini_set('display_errors', 1);

$requestURI = $_SERVER ['REQUEST_URI' ];

if ($requestURI === "/") {
    $booksController = new UserController('books-page.php');
     $booksController-> defineController('books-page.php');
} elseif($requestURI === '/views/book-page.php'){
    $bookController = new UserController();
    $bookController->defineController('book-page.php');
} elseif($requestURI === '/views/error.php'){
    echo "views error";
    $errorController = new ErrorController('error.php');
    $errorController -> printErrorPage();
} elseif($requestURI === 'test.php'){
    require_once 'app/controllers/ErrorController.php';
} elseif($requestURI === '/admin/a.php'){
   require_once __DIR__.'/app/controllers/AdminController.php';
}
else {
    echo 'else';
    $errorController = new ErrorController('error.php');
    $errorController -> printErrorPage();
}
// echo __FILE__;


/* request routing */
/* rewrite Nginx*/

/* logo, book, /views/book-page.php*/

//echo $requestURI;


const EXISTED_DIRS_PATHS =
[
     "/views/",
     "/views/books-page.php",
     "/views/book-page.php"
 ];


// Створюємо об'єкт Router


