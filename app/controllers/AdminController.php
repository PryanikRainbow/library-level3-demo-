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

        return method_exists($this, $action)
        ? $this->$action($action, $params)
        : render(self::USER_TEMPLATE_PATH . 'error.php');

    }

    public function printAdminPage($action, $params)
    {

        $booksModel = new \App\Models\BooksModel();
        $userContoller = new UserController();
        $adminModel = new \App\Models\AdminModel();

        if (isAllBooks($params) && http_response_code() === 200 &&
            isValidOffset($params['offset'], $userContoller->countBooks($params, $booksModel))
        ) {
            $offset = $params['offset'];
            $pre = $offset >= OFFSET_DEFAULT ? $offset - OFFSET_DEFAULT : 0;
            $dataBooks = $adminModel->getDataTableBooks(LIMIT_TABLE, $offset); 

            $next = $offset + OFFSET_DEFAULT;
            $countBooks = $userContoller->countBooks($params, $booksModel);

            $dataTemplate = [
                'dataBooks' => $dataBooks,
                'pre' => $pre,
                'next' => $next,
                'isFirstPage' => isFirstBooksPage($pre, $next),
                'isLastPage' => isLastBooksPage($countBooks, $next),
            ];

            render(self::ADMIN_TEMPLATE_PATH . "/header.php", $dataTemplate);
            // render(self::ADMIN_TEMPLATE_PATH . "/admin-book.php");
            render(self::ADMIN_TEMPLATE_PATH . "/admin-page.php", $dataTemplate);
            render(self::ADMIN_TEMPLATE_PATH . "/footer.php", $dataTemplate);

        } else {
            var_dump(isValidOffset($params['offset'], $userContoller->countBooks($params, $adminModel)));
            render(self::USER_TEMPLATE_PATH . '/error.php');
        }
    }

}
