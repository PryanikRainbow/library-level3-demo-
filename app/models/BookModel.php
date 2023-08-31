<?php

namespace App\Models;

// require_once __DIR__ . '/ConnectDB.php';
// use App\Models\ConnectDB;


// error_reporting(E_ALL);
// ini_set('display_errors', 1);

class BookModel
{
    const SELECT_BOOK = "SELECT books.*,  GROUP_CONCAT(authors.author SEPARATOR '\n') AS author
    FROM `books`
    JOIN `books_authors` ON books.id = books_authors.book_id
    JOIN `authors` ON books_authors.author_id = authors.id
    WHERE books.id = ?
    GROUP BY books.id";

    public function getDataBook($id)
    {
        $db = ConnectDB::getInstance();

        $stmt = $db->prepare(self::SELECT_BOOK);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $result = $stmt->get_result()->fetch_assoc();

            if ($result) {
                return $result;
            }
        }

        return false;
    }

    public function incrementCounter($id, $counterType)
    {
        $db = ConnectDB::getInstance();
        $query = 'UPDATE books
        SET ' . $counterType . 'Counter = ' . $counterType . 'Counter + 1
        WHERE id = ?;';

        $stmt = $db->prepare($query);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function getCounter($id, $counterType)
    {
        $db = ConnectDB::getInstance();
        $query = 'SELECT ' .  $counterType . 'Counter FROM books WHERE id = ?;';

        $stmt = $db->prepare($query);
        $stmt -> bind_param('i', $id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_row();
            if ($row) return (int)$row[0];
            
        }
    }

}