<?php

namespace App\Models;

require __DIR__ . '/../../vendor/autoload.php';

class BooksModel
{
    private const SELECT_BOOKS = "SELECT books.id, books.img, books.title, GROUP_CONCAT(authors.author SEPARATOR ', ') AS author
    FROM books
    JOIN books_authors ON books.id = books_authors.book_id
    JOIN authors ON books_authors.author_id = authors.id
    GROUP BY books.id
    LIMIT 20 OFFSET ?";

    public const COUNT_ALL_BOOKS = 'SELECT COUNT(*) FROM books;';

    public const SELECT_BOOK = "SELECT books.*, GROUP_CONCAT(authors.author SEPARATOR ', ') AS author
    FROM `books`
    JOIN `books_authors` ON books.id = books_authors.book_id
    JOIN `authors` ON books_authors.author_id = authors.id
    WHERE books.id = ?
    GROUP BY books.id;";

    public function getDataTotalBooks($offset)
    {
        try {
            $db = ConnectDB::getInstance();
            $stmt = $db->prepare(self::SELECT_BOOKS);
            $stmt->bind_param("i", $offset);

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $dataBooksArray = $result->fetch_all(MYSQLI_ASSOC);
                return $dataBooksArray;
            }
        } catch (\Exception $e) {
            http_response_code(500);
            require_once(__DIR__ . '/../../views/error.php');
        } catch (\Throwable $t) {
            http_response_code(500);
            require_once(__DIR__ . '/../../views/error.php');
        }
    }

    public function getDataBooksBySearch($offset, $searchType, $searchBook)
    {
        try {
            $db = ConnectDB::getInstance();
            $field = in_array($searchType, ['title', 'year']) ? "books.$searchType" : "authors.$searchType";

            $querySearch = "SELECT books.id, books.img, books.title, GROUP_CONCAT(authors.author SEPARATOR ', ') AS author
            FROM books
            JOIN books_authors ON books.id = books_authors.book_id
            JOIN authors ON books_authors.author_id = authors.id
            WHERE {$field} LIKE CONCAT('%', ?, '%')
            GROUP BY books.id
            LIMIT 20 OFFSET ?";

            $stmt = $db->prepare($querySearch);
            $stmt->bind_param("si", $searchBook, $offset);

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $dataBooksArray = $result->fetch_all(MYSQLI_ASSOC);
                return $dataBooksArray;
            }
        } catch (\Exception $e) {
            http_response_code(500);
            require_once(__DIR__ . '/../../views/error.php');
        } catch (\Throwable $t) {
            http_response_code(500);
            require_once(__DIR__ . '/../../views/error.php');
        }
    }

    public function getCountRowsBooks($isBooksBySearch)
    {
        try {
            $db = ConnectDB::getInstance();

            if (!$isBooksBySearch) {
                $result = $db->query(self::COUNT_ALL_BOOKS);
            } else {
                $searchType = $_GET['select-by'];
                $searchBook = "%{$_GET['search-book']}%";
                $field = in_array($searchType, ['title', 'year']) ? "books.$searchType" : "authors.$searchType";

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
                if ($result->num_rows === 1) {
                    $row = $result->fetch_row();
                    
                    return (int)$row[0];
                }
                return $result->num_rows;
            }
        } catch (\Exception $e) {
            http_response_code(500);
            require_once(__DIR__ . '/../../views/error.php');
        } catch (\Throwable $t) {
            http_response_code(500);
            require_once(__DIR__ . '/../../views/error.php');
        }
    }

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
        } catch (\Exception $e) {
            http_response_code(500);
            require_once(__DIR__ . '/../../views/error.php');
        } catch (\Throwable $t) {
            http_response_code(500);
            require_once(__DIR__ . '/../../views/error.php');
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
            require_once(__DIR__ . '/../../views/error.php');
        } catch (\Throwable $t) {
            http_response_code(500);
            require_once(__DIR__ . '/../../views/error.php');
        }
    }

    public function getCounter($id, $counterType)
    {
        try {
            $db = ConnectDB::getInstance();
            $query = 'SELECT ' . $counterType . 'Counter FROM books WHERE id = ?;';
            $stmt = $db->prepare($query);
            $stmt->bind_param('i', $id);

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $row = $result->fetch_row();

                if ($row) {
                    return (int)$row[0];
                }
            }
        } catch (\Exception $e) {
            http_response_code(500);
            require_once(__DIR__ . '/../../views/error.php');
        } catch (\Throwable $t) {
            http_response_code(500);
            require_once(__DIR__ . '/../../views/error.php');
        }
    }
}

