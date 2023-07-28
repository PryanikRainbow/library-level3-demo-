<?php

namespace app\controllers;

require_once 'Controller.php';

const USER_TEMPLATE_PATH = __DIR__ . '/../../views/';
#дані має витягувати контролер (до моделей)

error_reporting(E_ALL);
ini_set('display_errors', 1);

class UserController extends Controller
{
    public function get($action)
    {
        switch ($action) {
            case 'books-page.php':
                $this->printBooksPage($action);
                break;
            case 'books-page.php':
                $this -> printBookPage($action);
                break;
            default:
                require_once __DIR__ . '/../../views/error.php';
                break;
        }
    }

    public function printBooksPage($action)
    {
        //витягнути з БД
        echo "printBooks";
        require_once USER_TEMPLATE_PATH . '/header.php';
        require_once USER_TEMPLATE_PATH . '//' . $action;
        require_once __DIR__ . '/footer.php';
    }

    public function printBookPage($action)
    {
        //витягнути з БД
        echo "book";
        // require_once __DIR__ . '/../../views/header.php';
        // require_once __DIR__ . '/../../views/book-page.php';
        // require_once __DIR__ . '/../../views/footer.php';
    }

}

// public function get($action) {
//     switch ($action) {
//         case 'books-page.php':
//             require_once __DIR__ . '/../../views/books-page.php';
//             break;
//         case 'books-page.php':
//             require_once __DIR__ . '/../../views/books-page.php';
//             break;
//         default:
//             // Помилка: дія не підтримується
//             require_once __DIR__ . '/../../views/error.php';
//             break;
//     }
// }

// public function post($action) {
//     switch ($action) {
//         case 'create':
//             // Виконати дії для створення користувача (метод POST)
//             echo "Створення користувача (POST)";
//             break;
//         case 'edit':
//             // Виконати дії для редагування користувача (метод POST)
//             echo "Редагування користувача (POST)";
//             break;
//         default:
//             // Помилка: дія не підтримується
//             echo "Помилка: невідома дія";
//             break;
//     }
// }
