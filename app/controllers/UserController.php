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

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

const USER_TEMPLATE_PATH = __DIR__ . '/../../views/';
//дані має витягувати контролер (до моделей)


class UserController extends Controller
{
    public function defineController($obj, $params = null)
    {
        $action = "print$obj";
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

    private function printBooks($action, $params)
    {
        // echo $action . PHP_EOL;
        // var_dump($params);
        // echo "printBooksMethod";

        $dataBooks = $this->selectDataBooks($params);
        // $pre = $offsetCurrent !== 0 ? $offsetCurrent - OFFSET_DEFAULT : 0;
        // $next = $offsetCurrent + OFFSET_DEFAULT;
        // echo getCountRowsBooks();

        if ($dataBooks != false) {
            $dataTemplate = [
              'dataBooks' => $dataBooks,
              'pre' => $pre,
              'next' => $next,
              'isFirstPage' => isFirstBooksPage($pre, $next, $searchType = null, $param = null),
              'isLastPage' => isLastBooksPage(getCountRowsBooks(), $next, $searchType = null, $param = null)
            ];

            render(USER_TEMPLATE_PATH . '/books-page.php', $dataTemplate);
        } else {
            render(USER_TEMPLATE_PATH . '/error.php');
        }

    }

    //роутери, контролел, ДБ,
    private function printBook($action, $params)
    {
        //спробувати витягнути з БД парам. Якщо не вийде, помилку
        $dataBook = getDataBook($params[0]);
        if ($dataBook != false) {
            render(USER_TEMPLATE_PATH . 'book-page.php', $dataBook);

        } else {
            // echo "not found!";

            render(USER_TEMPLATE_PATH . '/error.php');
        }
    }

    private function printCounter($action, $params)
    {
        if (isset($_POST['id']) && isset($_POST['counter-type'])
        && count($_POST) === 2) {
            $id = $_POST['id'];
            $counterType = $_POST['counter-type'];

            incrementCounter($id, $counterType);
            $newCounter = getCounter($id, $counterType);

            echo $newCounter;
        } else {
            render(USER_TEMPLATE_PATH . '/error.php');
        }
    }

    private function selectDataBooks($params)
    {
        if($this->isAllBooks($params)) {
            // if (empty($params['offset'])) {
            //     $params['offset'] = 0;
            // }
            return getDataBooks(LIMIT, $params['offset']);
        }
        if ($this->isBooksBySearch($params)) {
            return getDataBooks(LIMIT, $params['offset'], $params['select-by'], ['search-book'], $params['offset']);
        }
        //return error?

    }

    private function isAllBooks($params)
    {
        return  count($params) === 1 && isset($params['offset']);
    }

    private function isBooksBySearch($params)
    {
//подумать, що робити, якщо пошук пустий або тип пошуку
        return count($params) === 3 &&
               isset($params['select-by']) && 
               in_array($params['select-by'], array_keys(SEARCH_OPTIONS)) &&
               isset($params['search-book']) && !empty($params['search-book']) &&
               isset($params['offset']);
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
