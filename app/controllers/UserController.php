<?php

namespace app\controllers;

use function app\models\getDataBooks;

require_once __DIR__ . '/../../includes/render.php';
require_once 'Controller.php';
require __DIR__ . '/../models/BooksModel.php';

const USER_TEMPLATE_PATH = __DIR__ . '/../../views/';
//дані має витягувати контролер (до моделей)

error_reporting(E_ALL);
ini_set('display_errors', 1);

class UserController extends Controller
{
    public static function defineController($action)
    {
        switch ($action) {
            case 'books-page.php':
                self::printBooksPage($action);
                break;
            case 'book-page.php':
                self::printBookPage($action);
                break;
            default:
                require_once USER_TEMPLATE_PATH . '/error.php';
                break;
        }
    }

    private static function printBooksPage($action)
    {
        //витягнути з БД
        echo "printBooks";
        require_once USER_TEMPLATE_PATH . '/header.php';

        // Зчитуємо вміст файлу books-page.php
        // $templateOrigin = file_get_contents(USER_TEMPLATE_PATH . '/' . $action);
        $dataBooks = getDataBooks();

        render(USER_TEMPLATE_PATH . '/' . $action, $dataBooks);
        // Вивести весь вміст сторінки з вставленими книгами
        // echo $templateOrigin;

        require_once USER_TEMPLATE_PATH . '/footer.php';
    }

    // private static function printBooksPage($action)
    // {
    //     //витягнути з БД
    //     echo "printBooks";
    //     require_once USER_TEMPLATE_PATH . '/header.php';

    //     $templateOrigin = file_get_contents(USER_TEMPLATE_PATH . '/' . $action);
    //     $dataBooks = getDataBooks();
    //     // echo $dataBooks();

    //     while ($row = $dataBooks->fetch_assoc()) {
    //         echo 'j';
    //         $bookTemplate = $templateOrigin;  // Копіюємо шаблон для кожної книги

    //         // Замінюємо мітки в шаблоні на дані з БД
    //         $bookTemplate = str_replace('{{book_image}}', $row['img'], $bookTemplate);
    //         $bookTemplate = str_replace('{{book_title}}', $row['title'], $bookTemplate);
    //         $bookTemplate = str_replace('{{book_author}}', $row['author'], $bookTemplate);

    //         echo $bookTemplate;
    //     }

    //     // require_once USER_TEMPLATE_PATH . '//' . $action;
    //     require_once USER_TEMPLATE_PATH . '/footer.php';
    // }

    private static function printBookPage($action)
    {
        //витягнути з БД
        echo "book";
        require_once __DIR__ . '/../../views/header.php';
        require_once __DIR__ . '/../../views/book-page.php';
        require_once __DIR__ . '/../../views/footer.php';
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
