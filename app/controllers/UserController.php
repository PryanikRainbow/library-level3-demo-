<?php

namespace app\controllers;

use function app\models\getCountRowsBooks;
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
    public function defineController($action, $numParam=null)
    {
        switch ($action) {
            case 'books-page':
                $this -> printBooksPage($action, $numParam);
                break;
            case 'book-page':
                $this -> printBookPage($action, $numParam);
                break;
            default:
                render(USER_TEMPLATE_PATH . "error.php");
                break;
        }
    }

    private function printBooksPage($action, $offsetCurrent = 0)
    {
        // echo "printBooksMethod";
        
        $dataBooks = getDataBooks(LIMIT, $offsetCurrent);
        $pre = $offsetCurrent !== 0 ? $offsetCurrent - OFFSET_DEFAULT : 0;
        $next = $offsetCurrent + OFFSET_DEFAULT;
        echo getCountRowsBooks();

        if ($dataBooks != false) {
            $dataTemplate = [
              'dataBooks' => $dataBooks,
              'pre' => $pre,
              'next' => $next,
              'isFirstPage' => isFirstBooksPage($pre, $next),
              'isLastPage' => isLastBooksPage(getCountRowsBooks(), $next)
            ];

            render(USER_TEMPLATE_PATH . '/header.php');
            // echo $offset; //тут оффсет видно
            render(USER_TEMPLATE_PATH . '/' . $action . '.php', $dataTemplate); //в шаблоні ні
            render(USER_TEMPLATE_PATH . '/footer.php');
        } else {
            render(USER_TEMPLATE_PATH . '/error.php');
        }

    }

    private function printBookPage($action, $id)
    {
        //спробувати витягнути з БД парам. Якщо не вийде, помилку
        echo "book";
        $dataBook = getDataBook($id);
        if ($dataBook != false) {
            render(USER_TEMPLATE_PATH . '/header.php');
            render(USER_TEMPLATE_PATH . $action . '.php', $dataBook);
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
