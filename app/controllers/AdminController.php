<?php

namespace App\Controllers;

require __DIR__ . '/../../vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

class AdminController
{
    public const USER_TEMPLATE_PATH = __DIR__ . '/../../views/';
    public const ADMIN_TEMPLATE_PATH = __DIR__ . '/../../admin/views/';

    public function defineController($obj, $params)
    {
        $action = '';
        if ($obj === "AdminPage") {
            $action = "print$obj";
        }
        // if(isset($params['action'])) $action = $params['action'] . $obj;
        // echo $action;

        return method_exists($this, $action)
        ? $this->$action($action, $params)
        : render(self::USER_TEMPLATE_PATH . 'error.php');

    }

    public function printAdminPage($action, $params)
    {
        // var_dump($params);
        // echo $_GET['id'];

        $booksModel = new \App\Models\BooksModel();
        $userContoller = new UserController();
        $adminModel = new \App\Models\AdminModel();

        if (isAllBooks($params) && http_response_code() === 200 &&
            isValidOffset($params['offset'], $userContoller->countBooks($params, $booksModel))
        ) {
            $offset = $params['offset'];
            $pre = $offset >= OFFSET_DEFAULT ? $offset - OFFSET_DEFAULT : 0;
            $dataBooks = $adminModel->getDataTableBooks(LIMIT_TABLE, $offset);


            $dataTemplate = [
                'dataBooks' => $dataBooks,
                'countBooks' => $userContoller->countBooks($params, $booksModel),
                'currentPage' => $userContoller->countBooks($params, $booksModel)/LIMIT_TABLE
                // 'isOpenBookInfo' => isOpenBookInfo($params),
                // 'dataConteinerBook' => $dataConteinerBook,

            ];

            if (isOpenBookInfo($params) && $adminModel->checkExistsID($params['id'])) {
                $dataTemplate['dataConteinerBook'] = $adminModel->getBookInfo($params['id']);
                $dataTemplate['id'] = $params['id'];
            }

            render(self::ADMIN_TEMPLATE_PATH . "/header.php", $dataTemplate);
            // render(self::ADMIN_TEMPLATE_PATH . "/admin-book.php");
            render(self::ADMIN_TEMPLATE_PATH . "/admin-page.php", $dataTemplate);
            render(self::ADMIN_TEMPLATE_PATH . "/footer.php", $dataTemplate);

        } else {
            render(self::USER_TEMPLATE_PATH . '/error.php');
        }
    }

    // public function getDataBookAdmin($adminModel, $dataBooks, $id){
    //     $dataBookAdmin = [];

    //     foreach ($dataBooks as $book) {
    //         if ($book['id'] == $id) {
    //             $dataBookAdmin['id'] = $book['id'];
    //             $dataBookAdmin['title'] = $book['title'];
    //             $dataBookAdmin['author'] = $book['author'];
    //             $dataBookAdmin['year'] = $book['year'];
    //             break;
    //         }
    //     }
    // }

    public function addBook($action, $params)
    {
        echo 'addBook';
    }

    public function removeBook($action, $params)
    {
        echo 'deleteBook';
    }

}
