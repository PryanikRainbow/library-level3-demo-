<?php

namespace App\Models;

class BookModel
{
    public const SELECT_BOOK = "SELECT books.*,  GROUP_CONCAT(authors.author SEPARATOR '\n') AS author
    FROM `books`
    JOIN `books_authors` ON books.id = books_authors.book_id
    JOIN `authors` ON books_authors.author_id = authors.id
    WHERE books.id = ?
    GROUP BY books.id";
    
    //change
    public function getDataBook($id)
    {
        try {
            $db = ConnectDB::getInstance();

            $stmt = $db->prepare(self::SELECT_BOOK);
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

    public function incrementCounter($id, $counterType)
    {
        try {
            $db = ConnectDB::getInstance();
            $query = 'UPDATE books
                SET ' . $counterType . 'Counter = ' . $counterType . 'Counter + 1
                WHERE id = ?;';

            $stmt = $db->prepare($query);
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                return true;
            }
        } catch (\Exception $e) {
            http_response_code(500);
        }
    }

    public function getCounter($id, $counterType)
    {
        try {
            $db = ConnectDB::getInstance();
            $query = 'SELECT ' .  $counterType . 'Counter FROM books WHERE id = ?;';

            $stmt = $db->prepare($query);
            $stmt -> bind_param('i', $id);

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $row = $result->fetch_row();
                if ($row) {
                    return (int)$row[0];
                }

            }
        } catch (\Exception $e) {
            http_response_code(500);
        }
    }

}
