<?php

namespace App\Models;

require __DIR__ . '/../../vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

class BooksModel
{
    public function getDataBooks($limit, $offset, $searchType = null, $searchBook = null)
    {
        echo $offset;
        // var_dump($searchBook);
        // echo PHP_EOL;
        // var_dump($searchType);
        $db = ConnectDB::getInstance();

        if ($searchType === null || ($searchType !== null && $searchBook === '')) {
            // echo "empty";
            $query = (file_get_contents(__DIR__ . '/../../db/select_books.sql'));
            $stmt = $db->prepare($query);
            $stmt->bind_param("ii", $limit, $offset);
        } else {
            $query = (file_get_contents(__DIR__ . "/../../db/search_by_$searchType.sql"));
            $stmt = $db->prepare($query);

            $stmt->bind_param("sii", $searchBook, $limit, $offset);
        }

        if ($stmt->execute()!=false) {
            $result = $stmt->get_result();
            $dataBooksArray = $result->fetch_all(MYSQLI_ASSOC);
    // echo "exec";
    var_dump(($offset));
    // var_dump($dataBooksArray);

            return $dataBooksArray;
        }

        return false;
    }

    public function getCountRowsBooks($isAllBooks, $isBooksBySearch)
    {
        $db = ConnectDB::getInstance();

        if ($isAllBooks === true) {
            $query = (file_get_contents(__DIR__ . '/../../db/count_rows_books_table.sql'));
            $result = $db->query($query);
        } elseif ($isBooksBySearch === true) {
            $query = (file_get_contents(__DIR__ . "/../../db/count_books_by_" . urlencode($_GET['select-by']) . "_search.sql"));
            $result = $db->prepare($query);
            $searchBook = urlencode($_GET['search-book']);
            
            $result->bind_param("s", $searchBook);
            $result->execute();
            $result = $result->get_result();
        }  

        if (isset($result) && $result && $result->num_rows === 1) {
            $row = $result->fetch_row();
            echo (int)$row[0];
            return (int)$row[0];
        }

        return false;
    }

}


// $dataBooks = getDataBooks();
// $dataBooksArray = [];

// while($row = $dataBooks->fetch_assoc()) {
//     //в масив додаємо масив асоціативних масивів(або пар)
//     $dataBooksArray[] = [
//         "img" => $row["img"],
//         "title" => $row["title"],
//         "author" => $row["author"]
//     ];
// }

// print_r($dataBooksArray);


// if ($dataBooks->num_rows > 0) {
//     while ($row = $dataBooks->fetch_assoc()) {
//       echo   $row["title"] . " " . $row["author"] . " " . $row["img"];
//     }
// } else {
//     echo "Немає результатів";
// }
