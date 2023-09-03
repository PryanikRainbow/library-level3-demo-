<?php

namespace App\Models;

class AdminModel {

    private const SELECT_BOOKS_A = "SELECT books.id, books.title, GROUP_CONCAT(authors.author SEPARATOR ', ') AS author,
    books.year, books.wantsCounter, books.viewsCounter
    FROM books
    JOIN books_authors ON books.id = books_authors.book_id
    JOIN authors ON books_authors.author_id = authors.id
    GROUP BY books.id
    LIMIT ? OFFSET ?";

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

}



?>