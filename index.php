<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/vendor/autoload.php'; 

$requestURI = $_SERVER ['REQUEST_URI' ];
$requestMethod = $_SERVER['REQUEST_METHOD'];

$router = new \Components\Router;

$router::addRoute('GET', '/', 'UserController', 'printBooks');
$router::addRoute('GET', '/book/', 'UserController', 'printBookByID');
$router::addRoute('POST', '/counter/', 'UserController', 'printCounter');
$router::addRoute('GET', '/logout', 'AdminController', 'logout');
$router::addRoute('GET', '/admin/page/', 'AdminController', 'printAdminPage');
$router::addRoute('POST', '/book/add', 'AdminController', 'addBook');
$router::addRoute('POST', '/book/remove', 'AdminController', 'removeBook');
