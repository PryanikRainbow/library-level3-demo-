<?php

// require_once __DIR__.'/app/controllers/UserController.php';
require_once 'app/controllers/UserController.php';
// require_once 'app/controllers/AdminController.php';
use app\controllers\UserController; // Вірно, якщо UserController.php у директорії app/controllers

error_reporting(E_ALL);
ini_set('display_errors', 1);

/* інші частини коду */

$requestURI = $_SERVER ['REQUEST_URI' ];

$found = false;

if ($requestURI === "/") {
    $booksController = new UserController();
     $booksController->get('books-page.php');
    // echo $output;
} elseif($requestURI === '/views/book-page.php'){
    // echo "kjhgh";
    $bookController = new UserController();
    $bookController->printBookPage();
//     echo "Request has reached index.php<br>";
// var_dump($_SERVER['REQUEST_URI']);
// var_dump($_GET);
} elseif($requestURI === '/views/error.php'){
    echo "error!";
    $bookController = new UserController();
    $bookController->printBookPage();
} elseif($requestURI === 'test.php'){
    // echo "error!";
    $bookController = new UserController();
    $bookController->printBookPage();
} elseif($requestURI === '/admin/a.php'){
   require_once __DIR__.'/app/controllers/AdminController.php';
}
else {
    require_once __DIR__ . '/app/controllers/ErrorController.php';
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


