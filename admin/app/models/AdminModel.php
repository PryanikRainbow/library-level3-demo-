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

    private const SELECT_BOOK_A = "SELECT books.id, books.title,  GROUP_CONCAT(authors.author SEPARATOR ', ') AS author,
        books.year,  books.description, books.img
        FROM `books`
        JOIN `books_authors` ON books.id = books_authors.book_id
        JOIN `authors` ON books_authors.author_id = authors.id
        WHERE books.id = ?
        GROUP BY books.id";

    private const ADD_DATA_TO_BOOKS_TABLE = "INSERT INTO books (title, year, description) VALUES (?, ?, ?);";
    private const ADD_BOOK_IMG = "UPDATE books SET img = ? WHERE id = ?";
    public const PATH_TO_IMGS = __DIR__ . "/../../../public/images/";
    public const AUTHOR_EXISTS = "SELECT id FROM authors WHERE author = ? LIMIT 1";

    public const MAX_ID = 'SELECT MAX(id) FROM books;';

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
        } catch (\Throwable $t) {
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
        } catch (\Exception $e) {
            http_response_code(500);
            require_once(__DIR__ . '/../../../views/error.php');
        } catch (\Throwable $t) {
            http_response_code(500);
            require_once(__DIR__ . '/../../../views/error.php');
        }
    }

    public function insertBook()
    {
        try {
            $db = ConnectDB::getInstance();

            $db->begin_transaction();

            $id = $this->insertDataToBooksTable($db);
            $this->insertIMG($db, $id);
            $this->insertAuthors($db, $id);

            $db->commit();
            $db->close();
        } catch (\Exception $e) {
            http_response_code(500);
            require_once(__DIR__ . '/../../../views/error.php');
        } catch (\Throwable $t) {
            http_response_code(500);
            echo $t;
            require_once(__DIR__ . '/../../../views/error.php');
        }
    }

    private function insertDataToBooksTable($db)
    {
        try {
            $stmt = $db->prepare(self::ADD_DATA_TO_BOOKS_TABLE);
            $stmt->bind_param("sis", $_POST['title'], $_POST['year'], $_POST['description']);

            if (!$stmt->execute()) {
                $this->failedTransaction($db);
            }

            return $this->maxID($db); 
        } catch (\Exception $e) {

            $this->failedTransaction($db);
        }
    }

    private function insertIMG($db, $id)
    {
        try {
            if(isset($_FILES['image']) && $_FILES['image']['error'] == 0 && !empty($_FILES['image']['name'])) {

                $newImageName = $id . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $uploadPath = self::PATH_TO_IMGS . $newImageName;

                move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath);

                $stmt = $db->prepare(self::ADD_BOOK_IMG);
                $stmt->bind_param("si", $newImageName, $id);

                if (!$stmt->execute()) {
                    $this->failedTransaction($db);
                }
            } else {
                $newImageName = "not_found.jpg";
                $stmt = $db->prepare(self::ADD_BOOK_IMG);
                $stmt->bind_param("si", $newImageName, $id);

                if (!$stmt->execute()) {
                    $this->failedTransaction($db);
                }
            }
        } catch (\Exception $e) {
            $this->failedTransaction($db);
        }
    }


    private function insertAuthors($db, $id)
    {
        $authors = $_POST['authors'];
        $this->authorUnspecifiedCheck($authors);

        foreach ($authors as $author) {
            if (!empty($author)) {

                $authorId = $this->authorExists($db, $author);

                if (empty($authorId)) { 
                    $sql = "INSERT INTO `authors` (`author`) VALUES (?)";
                    $stmt = $db->prepare($sql);
                    $stmt->bind_param("s", $author);
                    $stmt->execute();

                    $authorId = $stmt->insert_id;
                    $stmt->close();
                }

                if (!empty($authorId)) {
                    $sql = "INSERT INTO `books_authors` (`book_id`, `author_id`) VALUES (?, ?)";
                    $stmt = $db->prepare($sql);
                    $stmt->bind_param("ii", $id, $authorId);
                    $stmt->execute();
                }
            }
        }
    }

    private function authorUnspecifiedCheck(&$authors)
    {
        if(empty($authors[0]) && count(array_unique($_POST['authors'])) === 1) {
            $authors = ['не указан'];
        }
    }

    public function maxID($db)
    {
        return $db->query(self::MAX_ID)->fetch_assoc()['MAX(id)'];
    }

    public function authorExists($db, $author)
    {
        $stmt = $db->prepare(self::AUTHOR_EXISTS);
        $stmt->bind_param("s", $author);
 
        if (!$stmt->execute()) {
            $this->failedTransaction($db);
        }

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['id']; 
        }
        return null; 
    }


    public function failedTransaction($db)
    {
        $db->rollback();
        http_response_code(500);
        require_once(__DIR__ . '/../../../views/error.php');
    }

}
