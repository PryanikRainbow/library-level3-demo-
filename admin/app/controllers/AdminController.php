<?php

namespace App\Controllers;

require __DIR__ . '/../../../vendor/autoload.php';
use App\Models\BooksModel;
use App\Models\AdminModel;

class AdminController
{
    const OFFSET_TABLE_DEFAULT = 10;
    public const ADMIN_TEMPLATE_PATH = __DIR__ . '/../../views/';

    private $booksModel;
    private $adminModel;

    public function __construct()
    {
        $this->booksModel = new BooksModel();
        $this->adminModel = new AdminModel();
    }

    public function printAdminPage($params)
    {
        $this->basicAuth();
        $this->isValidBooksPageParams($params);

        try {
            $countBooks = $this->booksModel->getCountRowsBooks(false);

            $dataTemplate = [
                'dataBooks' =>  $this->adminModel->getDataTableBooks(
                        $this->offset($params['page']),
                        self::OFFSET_TABLE_DEFAULT
                    ),
                'countBooks' => $countBooks,
                'page' => (int)$params['page'],
                'countPages' => ceil($countBooks / self::OFFSET_TABLE_DEFAULT)
            ];

            if ($this->isOpenBookInfo($params)) {
                $dataTemplate['dataConteinerBook'] = $this->adminModel->getBookInfo($params['id']);
                $dataTemplate['id'] = (int)$params['id'];
            }

            render(self::ADMIN_TEMPLATE_PATH . "/header.php", $dataTemplate);
            render(self::ADMIN_TEMPLATE_PATH . "/admin-page.php", $dataTemplate);
            render(self::ADMIN_TEMPLATE_PATH . "/footer.php", $dataTemplate);

        } catch(\Exception $e) {
            http_response_code(500);
            require_once(__DIR__ . '/../../../views/error.php');
        }
    }

    //
    public function addBook()
    {
        $this->adminModel->insertBook();
        header('Location: /admin/page/'); 
        exit; 
    }

    public function removeBook()
    {
        var_dump($_POST);
    }

    //////////////////////////check params////////////////////////////////

    private function isValidBooksPageParams(&$params, $booksModel = null, $adminModel = null)
    {
        if(empty($params)) {
            $params = ['page' => 1];
            
            return true;
        }

        if ((count($params) === 1 && isset($params['page'])
            && is_numeric($params['page'])
            && $this->isValidPage($params, $booksModel)) ||
            ($this->isOpenBookInfo($params, $booksModel, $adminModel))) {

            return true;
        }

        http_response_code(404);
        require_once(__DIR__ . '/../../../views/error.php');
    }

    private function isOpenBookInfo($params)
    {
        return count($params) === 3 &&
        isset($params['action']) && $params['action'] === 'view' &&
        isset($params['id']) &&
        is_numeric($params['id']) &&
        isset($params['page']) &&
        is_numeric($params['page']) &&
        $this->isValidPage($params);
    }

    private function isValidPage($params)
    {
        $page = $params['page'];
        $offset = $this->offset($page);

        return $offset >= 0 &&
        $offset <= $this->booksModel->getCountRowsBooks(false);
    }

    private function offset($page)
    {
        return self::OFFSET_TABLE_DEFAULT * ($page - 1);
    }

    //https://gist.github.com/rchrd2/c94eb4701da57ce9a0ad4d2b00794131
    private function basicAuth()
    {
        $AUTH_USER = 'admin';
        $AUTH_PASS = 'admin';
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

    // private function basicAuth() {
    //     $userData = file_get_contents('/etc/nginx/.htpasswd');
    //     [$AUTH_USER, $storedHash] = explode(":", $userData, 2);

    //     header('Cache-Control: no-cache, must-revalidate, max-age=0');
    //     $hasSuppliedCredentials = !(empty($_SERVER['PHP_AUTH_USER']) && empty($_SERVER['PHP_AUTH_PW']));
    //     $isNotAuthenticated = (
    //         !$hasSuppliedCredentials ||
    //         $_SERVER['PHP_AUTH_USER'] != $AUTH_USER ||
    //         !password_verify($_SERVER['PHP_AUTH_PW'], $storedHash)
    //     );

    //     if ($isNotAuthenticated) {
    //         header('HTTP/1.1 401 Authorization Required');
    //         header('WWW-Authenticate: Basic realm="Access denied"');
    //         var_dump($AUTH_USER);
    //         var_dump($storedHash);
    //         exit;
    //     }
    // }





}
