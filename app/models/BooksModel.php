<?php

namespace App\Models;

require __DIR__ . '/../../vendor/autoload.php';

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

class BooksModel
{
    private const SELECT_BOOKS = "SELECT books.id, books.img, books.title, GROUP_CONCAT(authors.author SEPARATOR ', ') AS author
    FROM books
    JOIN books_authors ON books.id = books_authors.book_id
    JOIN authors ON books_authors.author_id = authors.id
    GROUP BY books.id
    LIMIT ? OFFSET ?";

    public const COUNT_ALL_BOOKS = 'SELECT COUNT(*) FROM books;';

    public function getDataBooks($limit, $offset, $searchType = null, $searchBook = null)
    {
        try {
            $db = ConnectDB::getInstance();

            // if ($db === null) {
            //     http_response_code(500);
            //     return false;
            // }

            if ($searchType === null || ($searchType !== null && $searchBook === '')) {

                $stmt = $db->prepare(self::SELECT_BOOKS);
                $stmt->bind_param("ii", $limit, $offset);
            } else {
                $field = in_array($searchType, ['title', 'year']) ? "books.$searchType" : "authors.$searchType";

                $querySearch = "SELECT books.id, books.img, books.title, GROUP_CONCAT(authors.author SEPARATOR ', ') AS author
                FROM books
                JOIN books_authors ON books.id = books_authors.book_id
                JOIN authors ON books_authors.author_id = authors.id
                WHERE {$field} LIKE CONCAT('%', ?, '%')
                GROUP BY books.id
                LIMIT ? OFFSET ?";

                $stmt = $db->prepare($querySearch);
                $stmt->bind_param("sii", $searchBook, $limit, $offset);
            }

            if ($stmt->execute() != false) {
                $result = $stmt->get_result();
                $dataBooksArray = $result->fetch_all(MYSQLI_ASSOC);

                return $dataBooksArray;
            }

        } catch (\Exception $e) {
            http_response_code(500);
            return false;
        } catch(\Throwable $t) {
            http_response_code(500);
            exit();
        }
    }

    public function getCountRowsBooks($isAllBooks, $isBooksBySearch)
    {
        try {
            $db = ConnectDB::getInstance();

            if ($isAllBooks === true) {
                $result = $db->query(self::COUNT_ALL_BOOKS);
            } elseif ($isBooksBySearch === true) {
                $searchType = $_GET['select-by'];
                $searchBook = "%{$_GET['search-book']}%";
                $table = ($searchType === 'title' || $searchType === 'year') ? 'books' : 'authors';
                $field = in_array($searchType, ['title', 'year']) ? "books.$searchType" : "authors.$searchType";

                // $query = "SELECT COUNT(*) FROM $table WHERE $searchType LIKE ? ;";

                $query = "SELECT COUNT(books.id) 
                FROM books
                JOIN books_authors ON books.id = books_authors.book_id
                JOIN authors ON books_authors.author_id = authors.id
                WHERE {$field} LIKE CONCAT('%', ?, '%')
                GROUP BY books.id";

                $result = $db->prepare($query);

                $result->bind_param("s", $searchBook);
                $result->execute();
                $result = $result->get_result();
            }

            if (isset($result) && $result) {

                if($result->num_rows === 1) {
                    $row = $result->fetch_row();

                    return (int)$row[0];
                }
                 
                return $result->num_rows;
            }

        } catch(\Exception $e) {
            http_response_code(500);
            return false;
        }
    }
}
