<?php

namespace App\Controllers;

require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../includes/render.php';
require_once __DIR__ . '/../../includes/call_migrations_files.php';


class UserController extends Controller
{

    const USER_TEMPLATE_PATH = __DIR__ . '/../../views/';

    public function defineController($obj, $params = null)
    {
        $action = "print$obj";
        return method_exists($this, $action)
            ? $this->$action($action, $params)
            : render(self::USER_TEMPLATE_PATH . '/error.php');
    }

    private function printBooks($action, $params)
    {
        $booksModel = new \App\Models\BooksModel();

        $dataBooks = $this->selectDataBooks($params, $booksModel);

        if (http_response_code() === 200 &&
            isValidOffset($params['offset'], $this->countBooks($params, $booksModel))
        ) {

            $offset = $params['offset'];
            $pre = $offset >= OFFSET_DEFAULT ? $offset - OFFSET_DEFAULT : 0;

            $next = $offset + OFFSET_DEFAULT;
            $countBooks = $this->countBooks($params, $booksModel);
            echo $countBooks;

            $dataTemplate = [
                'dataBooks' => $dataBooks,
                'pre' => $pre,
                'next' => $next,
                'isFirstPage' => isFirstBooksPage($pre, $next),
                'isLastPage' => isLastBooksPage($countBooks, $next),
                'searchMessage' => searchMessage($params, $countBooks)
            ];

            render(self::USER_TEMPLATE_PATH . '/books-page.php', $dataTemplate);
        } else {
            render(self::USER_TEMPLATE_PATH . '/error.php');
        }

    }

    private function printBook($action, $params)
    {
        $bookModel = new \App\Models\BookModel();
        $dataBook = $bookModel->getDataBook($params[0]);
        if ($dataBook !== false) {
            render(self::USER_TEMPLATE_PATH . 'book-page.php', $dataBook);
        } else {
            render(self::USER_TEMPLATE_PATH . '/error.php');
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
            render(self::USER_TEMPLATE_PATH . '/error.php');
        }
    }

    private function selectDataBooks($params, $booksModel)
    {
        if(isAllBooks($params)) {
            // if (empty($params['offset'])) {
            //     $params['offset'] = 0;
            // }
            return $booksModel->getDataBooks(LIMIT, $params['offset']);
        }
        if (isBooksBySearch($params)) {
            if($params['search-book'] !== '') {
                return $booksModel->getDataBooks(LIMIT, $params['offset'], $params['select-by'], $params['search-book']);
            } else {
                return $booksModel->getDataBooks(LIMIT, $params['offset']);
            }
        }
        http_response_code(404);

    }

    public function countBooks($params, $model){
       return $model->getCountRowsBooks(isAllBooks($params), isBooksBySearch($params));
    }

}

