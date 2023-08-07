<?php

namespace app\controllers;

use function app\models\getDataBook;
use function app\models\getDataBooks;

require_once __DIR__ . '/../../includes/render.php';
require_once 'Controller.php';
require __DIR__ . '/../models/BooksModel.php';
require __DIR__ . '/../models/BookModel.php';


error_reporting(E_ALL);
ini_set('display_errors', 1);

const USER_TEMPLATE_PATH = __DIR__ . '/../../views/';
//дані має витягувати контролер (до моделей)

error_reporting(E_ALL);
ini_set('display_errors', 1);

class UserController extends Controller
{
    public function defineController($action, $id = null)
    {
        switch ($action) {
            case 'books-page.php':
                $this -> printBooksPage($action);
                break;
            case 'book-page.php':
                $this -> printBookPage($action, $id);
                break;
            default:
                render(USER_TEMPLATE_PATH . '/error.php');
                break;
        }
    }

    private function printBooksPage($action)
    {
        //витягнути з БД
        echo "printBooks";
        render(USER_TEMPLATE_PATH . '/header.php');

        $dataBooks = getDataBooks();
        render(USER_TEMPLATE_PATH . '/' . $action, $dataBooks);

        render(USER_TEMPLATE_PATH . '/footer.php');
    }

    private function printBookPage($action, $id)
    {
        //спробувати витягнути з БД парам. Якщо не вийде, помилку
        echo "book";
        $data = getDataBook($id);
        if ($data != false) {
            render(USER_TEMPLATE_PATH . '/header.php');
            render(USER_TEMPLATE_PATH . $action, $data);
            render(USER_TEMPLATE_PATH . '/footer.php');
        } else {
            // echo "not found!";
            render(USER_TEMPLATE_PATH . '/error.php');
        }
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
