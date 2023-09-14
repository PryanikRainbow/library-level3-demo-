<?php

namespace App\Controllers;

use App\Models\BooksModel;
use Exception;

require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../includes/render.php';
require_once __DIR__ . '/../../includes/template-functions.php';
require_once __DIR__ . '/../public/public-constants.php';

class UserController extends Controller
{
    private $booksModel;

    public const USER_TEMPLATE_PATH = __DIR__ . '/../../views/';
    public const OFFSET_DEFAULT = 10;

    public function __construct()
    {
        $this->booksModel = new BooksModel();
    }

    public function printBooks($params)
    {
        $this->isValidBooksPageParams($params);

        $this->isValidOffset(
            $params,
            $this->booksModel->getCountRowsBooks($this->isParamsSelectBySearch($params))
        );

        $offset = (int)$params['offset'];

        if($this->isParamsTotalSelect($params)) {
            $dataBooks = $this->booksModel->getDataTotalBooks($offset);
        } else {
            $dataBooks = $this->booksModel->getDataBooksBySearch($offset, $params['select-by'], $params['search-book']);
        }

        $countBooks = $this->booksModel->getCountRowsBooks($this->isParamsSelectBySearch($params));

        try {
            $dataTemplate = [
                'dataBooks' => $dataBooks,
                'offset' => $offset,
                'pre' => $offset >= self::OFFSET_DEFAULT ? $offset - self::OFFSET_DEFAULT : 0,
                'next' => $offset + self::OFFSET_DEFAULT,
                'countBooks' => $countBooks,
                'isBooksBySearch' => $this->isParamsSelectBySearch($params),
            ];

            render(self::USER_TEMPLATE_PATH . '/books-page.php', $dataTemplate);
        } catch(Exception $e) {
            http_response_code(500);
            require_once(__DIR__ . '/../../views/error.php');
        }
    }

    public function printBookByID($params)
    {
        $dataBook = $this->booksModel->getDataBook($params[0]);

        try {
            if ($dataBook !== false && !empty($params)) {
                render(self::USER_TEMPLATE_PATH . 'book-page.php', $dataBook);
            } else {
                http_response_code(404);
                require_once(__DIR__ . '/../../views/error.php');
            }
        } catch(Exception $e) {
            http_response_code(500);
            require_once(__DIR__ . '/../../views/error.php');
        }
    }

    //empty
    public function printCounter()
    {
        try {
            $id = $_POST['id'];
            $counterType = $_POST['counter-type'];

            $this->booksModel->incrementCounter($id, $counterType);
            $newCounter = $this->booksModel->getCounter($id, $counterType);

            echo $newCounter;
        } catch(Exception $e) {
            http_response_code(500);
            require_once(__DIR__ . '/../../views/error.php');
        }
    }

    ///////////////////////////check params////////////////////////////////

    private static function isValidBooksPageParams(&$params)
    {
        if (self::isParamsTotalSelect($params) || (self::isParamsSelectBySearch($params))) {
            return true;
        }

        http_response_code(500);
        require_once(__DIR__ . '/../../views/error.php');
    }

    private static function isParamsTotalSelect(&$params)
    {
        if(empty($params)) {
            $params = ['offset' => 0];
            return true;
        }

        if(count($params) === 1 && isset($params['offset'])
         && is_numeric($params['offset'])) {
            return true;
        }

        return false;
    }

    private static function isParamsSelectBySearch($params)
    {
        return count($params) === 3 && self::isValidSearcType($params) &&
               isset($params['search-book']) &&
               isset($params['offset']) &&
               is_numeric($params['offset']);
    }

    private static function isValidOffset($params, $countBooks)
    {
        $offset = $params['offset'];
        if($offset >= 0 && $offset <= $countBooks) {
            return true;
        } else {
            http_response_code(404);

            echo json_encode(["error" => "Not Found"]);
            exit();
        }
    }

    private static function isValidSearcType($params)
    {
        return isset($params['select-by']) &&
        in_array($params['select-by'], array_keys(SEARCH_OPTIONS));
    }

}
