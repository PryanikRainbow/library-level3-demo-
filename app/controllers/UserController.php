<?php

namespace App\Controllers;

require __DIR__ . '/../../vendor/autoload.php';

use function App\Models\getCountRowsBooks;
use function App\Models\getDataBook;
use function App\Models\getDataBooks;
use function App\Models\incrementCounter;
use function App\Models\getCounter;


require_once __DIR__ . '/../../includes/render.php';
// require_once 'Controller.php';
// require __DIR__ . '/../models/BooksModel.php';
// require __DIR__ . '/../models/BookModel.php';

use CounterType;


error_reporting(E_ALL);
ini_set('display_errors', 1);

const USER_TEMPLATE_PATH = __DIR__ . '/../../views/';
//дані має витягувати контролер (до моделей)

error_reporting(E_ALL);
ini_set('display_errors', 1);

class UserController extends Controller
{
    public function defineController($action, $params = null){
        return method_exists($this, $action)
        ? $this->$action($action, $params)
        : render(USER_TEMPLATE_PATH . '/error.php');
    }
    // public function defineController($action, $param)
    // {
    //     switch ($action) {
    //         case 'books-page':
    //             $this -> books($action, $param);
    //             break;
    //         case 'book-page':
    //             $this -> printBookPage($action, $param);
    //             break;
    //         case '/ajax/wants-click/':
    //             $this -> rewriteCounter($param, CounterType::WANTS);
    //             break;
    //         case '/ajax/views-count/':
    //             $this -> rewriteCounter($param, CounterType::VIEWS);
    //             break;
    //         default:
    //             render(USER_TEMPLATE_PATH . "error.php");
    //             break;
    //     }
    // }

    private function printBooks($action, $offsetCurrent = 0)
    {
        // echo "printBooksMethod";

        $dataBooks = getDataBooks(LIMIT, $offsetCurrent);
        $pre = $offsetCurrent !== 0 ? $offsetCurrent - OFFSET_DEFAULT : 0;
        $next = $offsetCurrent + OFFSET_DEFAULT;
        // echo getCountRowsBooks();

        if ($dataBooks != false) {
            $dataTemplate = [
              'dataBooks' => $dataBooks,
              'pre' => $pre,
              'next' => $next,
              'isFirstPage' => isFirstBooksPage($pre, $next, $searchType = null, $param = null),
              'isLastPage' => isLastBooksPage(getCountRowsBooks(), $next, $searchType = null, $param = null)
            ];

            render(USER_TEMPLATE_PATH . '/header.php');
            render(USER_TEMPLATE_PATH . '/books-page.php', $dataTemplate);
            render(USER_TEMPLATE_PATH . '/footer.php');
        } else {
            render(USER_TEMPLATE_PATH . '/error.php');
        }

    }

    //роутери, контролел, ДБ,
    private function printBook($action, $params)
    {
        //спробувати витягнути з БД парам. Якщо не вийде, помилку
        echo "book";
        $dataBook = getDataBook($params[0]);
        if ($dataBook != false) {
            render(USER_TEMPLATE_PATH . '/header.php');
            render(USER_TEMPLATE_PATH . 'book-page.php', $dataBook);
            render(USER_TEMPLATE_PATH . '/footer.php');
        } else {
            // echo "not found!";
            render(USER_TEMPLATE_PATH . '/error.php');
        }
    }

    private function printCounter($action, $params)
    {
        $id = $_POST['id'];
        $counterType = $_POST['counter-type'];

        incrementCounter($id, $counterType);
        $newCounter = getCounter($id, $counterType);

        echo $newCounter;
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
