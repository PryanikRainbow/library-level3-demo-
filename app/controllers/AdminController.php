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
        $this->basicAut();
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
        var_dump($this->isOpenBookInfo($params, $booksModel, $adminModel));

        if ($this->isAllBooks($params, $booksModel, $adminModel) && http_response_code() === 200) {
            // $offset = $params['offset'];
            // $pre = $offset >= OFFSET_DEFAULT ? $offset - OFFSET_DEFAULT : 0;
            // $dataBooks = $adminModel->getDataTableBooks(LIMIT_TABLE, $offset);
            $countBooks = $booksModel->getCountRowsBooks(true, isBooksBySearch($params));


            $dataTemplate = [
                'dataBooks' =>  $adminModel->getDataTableBooks(LIMIT_TABLE, $this->offset($params['page'])),
                'countBooks' => $countBooks,
                'page' => $params['page'],
                'countPages' => ceil($countBooks / OFFSET_TABLE_DEFAULT)
                // 'isOpenBookInfo' => isOpenBookInfo($params),
                // 'dataConteinerBook' => $dataConteinerBook,

            ];

            if ($this->isOpenBookInfo($params, $booksModel, $adminModel) && $adminModel->checkExistsID($params['id'])) {
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

    private function isAllBooks($params, $booksModel = null, $adminModel = null)
    {
        return (count($params) === 1 && isset($params['page'])
        && is_numeric($params['page'])
        && $this->isValidPage($params, $booksModel)) ||
        ($this->isOpenBookInfo($params, $booksModel, $adminModel));
    }

    private function isOpenBookInfo($params, $booksModel, $adminModel)
    {
        // var_dump($params);
        return count($params) === 3 &&
        isset($params['action']) && $params['action'] === 'view' &&
        isset($params['id']) &&
        is_numeric($params['id']) &&
        $adminModel !== null &&
        $adminModel->checkExistsID($params['id']) &&
        isset($params['page']) &&
        is_numeric($params['page']) &&
        $this->isValidPage($params, $booksModel);
    }

    private function isValidPage($params, $booksModel)
    {
        $page = $params['page'];
        $offset = $this->offset($page);

        return $offset >= 0 &&
        $offset <= $booksModel->getCountRowsBooks(true, isBooksBySearch($params));
    }

    private function offset($page)
    {
        return OFFSET_TABLE_DEFAULT * ($page - 1);
    }

    //https://gist.github.com/rchrd2/c94eb4701da57ce9a0ad4d2b00794131
    private function basicAut(){
        $userData = file_get_contents('/etc/nginx/.htpasswd');
        [$AUTH_USER, $AUTH_PASS] = explode(":", $userData, 2);
        // $AUTH_USER = 'admin';
        // $AUTH_PASS = 'admin';
        header('Cache-Control: no-cache, must-revalidate, max-age=0');
        $hasSuppliedCredentials = !(empty($_SERVER['PHP_AUTH_USER']) && empty($_SERVER['PHP_AUTH_PW']));
        $isNotAuthenticated = (
            !$hasSuppliedCredentials ||
            $_SERVER['PHP_AUTH_USER'] != $AUTH_USER ||
            $_SERVER['PHP_AUTH_PW']   != $AUTH_PASS
        );
        if ($isNotAuthenticated) {
            header('HTTP/1.1 401 Authorization Required');
            header('WWW-Authenticate: Basic realm="Access denied"');
            exit;
        }
    }
}
