<?php

namespace App\Controllers;

use App\Models\BookModel;

require __DIR__ . '/../../vendor/autoload.php';
use function App\Models\getDataBook;
// use function App\Models\getDataBooks;
use function App\Models\incrementCounter;
use function App\Models\getCounter;

require_once __DIR__ . '/../../includes/render.php';

const USER_TEMPLATE_PATH = __DIR__ . '/../../views/';

class UserController extends Controller
{
    public function defineController($obj, $params = null)
    {
        $action = "print$obj";
        return method_exists($this, $action)
            ? $this->$action($action, $params)
            : render(USER_TEMPLATE_PATH . '/error.php');
    }

    private function printBooks($action, $params)
    {
        // echo $action . PHP_EOL;
        // var_dump($params);
        // echo "printBooksMethod";
        $booksModel = new \App\Models\BooksModel();

        $dataBooks = $this->selectDataBooks($params, $booksModel);

        // echo PHP_EOL;
        // echo PHP_EOL;
        // var_dump($dataBooks);

        if ($dataBooks !== false &&
            isValidOffset($params['offset'], $this->countBooks($params, $booksModel))
        ) {

            $offset = $params['offset'];
            $pre = $offset >= OFFSET_DEFAULT ? $offset - OFFSET_DEFAULT : 0;

            $next = $offset + OFFSET_DEFAULT;
            $countBooks = $this->countBooks($params, $booksModel);

            $dataTemplate = [
                'dataBooks' => $dataBooks,
                'pre' => $pre,
                'next' => $next,
                'isFirstPage' => isFirstBooksPage($pre, $next),
                'isLastPage' => isLastBooksPage($countBooks, $next),
                'searchMessage' => searchMessage($params, $countBooks)
            ];

            render(USER_TEMPLATE_PATH . '/books-page.php', $dataTemplate);
        } else {
            // Тут має бути помилка якщо не тру оффсет
            echo "(((";
            render(USER_TEMPLATE_PATH . '/error.php');
        }

    }

    //роутери, контролел, ДБ,
    private function printBook($action, $params)
    {
        $bookModel = new \App\Models\BookModel();
        //спробувати витягнути з БД парам. Якщо не вийде, помилку
        $dataBook = $bookModel->getDataBook($params[0]);
        if ($dataBook != false) {
            render(USER_TEMPLATE_PATH . 'book-page.php', $dataBook);

        } else {
            // echo "not found!";

            render(USER_TEMPLATE_PATH . '/error.php');
        }
    }

    private function printCounter($action, $params)
    {
        if (isset($_POST['id']) && isset($_POST['counter-type']) &&
           count($_POST) === 2
        ) {
            $id = $_POST['id'];
            $counterType = $_POST['counter-type'];

            $bookModel = new \App\Models\BookModel();
            $bookModel->incrementCounter($id, $counterType);
            $newCounter = $bookModel->getCounter($id, $counterType);

            echo $newCounter;
        } else {
            render(USER_TEMPLATE_PATH . '/error.php');
        }
    }

    private function selectDataBooks($params, $booksModel)
    {
        // $booksModel = new \App\Models\BooksModel();

        if(isAllBooks($params)) {
            // if (empty($params['offset'])) {
            //     $params['offset'] = 0;
            // }
            return $booksModel->getDataBooks(LIMIT, $params['offset']);
        }
        if (isBooksBySearch($params)) {
            if($params['search-book'] !== '') {
                return $booksModel->getDataBooks(LIMIT, $params['offset'], $params['select-by'], $params['search-book'], $params['offset']);
            } else {
                //потім переглянути
                return $booksModel->getDataBooks(LIMIT, $params['offset']);
            }
        }
        return false;
        //return error

    }

    private function countBooks($params, $booksModel){
       return $booksModel->getCountRowsBooks(isAllBooks($params), isBooksBySearch($params));
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
