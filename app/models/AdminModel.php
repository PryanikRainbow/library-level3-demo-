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
    LIMIT ? OFFSET ?";

    public const SELECT_BOOK_A = "SELECT books.id, books.title,  GROUP_CONCAT(authors.author SEPARATOR ', ') AS author,
    books.year,  books.description, books.img
    FROM `books`
    JOIN `books_authors` ON books.id = books_authors.book_id
    JOIN `authors` ON books_authors.author_id = authors.id
    WHERE books.id = ?
    GROUP BY books.id";

    private const ID_EXISTS = 'SELECT EXISTS (SELECT 1 FROM books WHERE id = ?) AS bookExists;';

    // public const SELECT_BOOK_A = "SELECT img, description FROM books WHERE id = ?; ";

    public function getDataTableBooks($limit, $offset)
    {
        try {

            $db = ConnectDB::getInstance();

            if ($db === null) {
                http_response_code(500);
                return false;
            }
            $stmt = $db->prepare(self::SELECT_BOOKS_A);
            $stmt->bind_param("ii", $limit, $offset);

            if ($stmt->execute() != false) {
                $result = $stmt->get_result();
                $dataBooksArray = $result->fetch_all(MYSQLI_ASSOC);

                return $dataBooksArray;
            }

        } catch (\Exception $e) {
            http_response_code(500);
            return false;
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
            return false;
        }

    }

    public function checkExistsID($id)
    {
        try {
            $db = ConnectDB::getInstance();

            $stmt = $db->prepare(self::ID_EXISTS);
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                $result = $stmt->get_result()->fetch_assoc();
                return ($result && $result['bookExists'] == 1);
            }
        
            return false;
        } catch(\Exception $e) {
            http_response_code(500);
        } 
    }

}
