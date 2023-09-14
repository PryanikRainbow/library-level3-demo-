<?php

namespace App\Models;

class AdminModel
{
    private const SELECT_BOOKS_A = "SELECT books.id, books.title, GROUP_CONCAT(authors.author SEPARATOR ', ') AS author,
    books.year, books.wantsCounter, books.viewsCounter
    FROM books
    JOIN books_authors ON books.id = books_authors.book_id
    JOIN authors ON books_authors.author_id = authors.id
    GROUP BY books.id
    LIMIT 10 OFFSET ?";

    public const SELECT_BOOK_A = "SELECT books.id, books.title,  GROUP_CONCAT(authors.author SEPARATOR ', ') AS author,
    books.year,  books.description, books.img
    FROM `books`
    JOIN `books_authors` ON books.id = books_authors.book_id
    JOIN `authors` ON books_authors.author_id = authors.id
    WHERE books.id = ?
    GROUP BY books.id";

    private const OFFSET_DEFAULT = 0; // Оголосіть OFFSET_DEFAULT зі значенням за замовчуванням

    public function getDataTableBooks($offset = self::OFFSET_DEFAULT)
    {
        try {
            $db = ConnectDB::getInstance();

            $stmt = $db->prepare(self::SELECT_BOOKS_A);
            $stmt->bind_param("i", $offset);

            if ($stmt->execute() != false) {
                $result = $stmt->get_result();
                $dataBooksArray = $result->fetch_all(MYSQLI_ASSOC);

                return $dataBooksArray;
            }
        } catch (\Exception $e) {
            http_response_code(500);
            require_once(__DIR__ . '/../../../views/error.php');
        } catch(\Throwable $t){
            http_response_code(500);
            require_once(__DIR__ . '/../../../views/error.php');
        }
    }

    public function getBookInfo($id)
    {
        try {
            $db = ConnectDB::getInstance();

            $stmt = $db->prepare(self::SELECT_BOOK_A);
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                $result = $stmt->get_result()->fetch_assoc();

                if ($result) {
                    return $result;
                }
            }
        } catch(\Exception $e) {
            http_response_code(500);
            require_once(__DIR__ . '/../../../views/error.php');
        } catch(\Throwable $t){
            http_response_code(500);
            require_once(__DIR__ . '/../../../views/error.php');
        }
    }
}
