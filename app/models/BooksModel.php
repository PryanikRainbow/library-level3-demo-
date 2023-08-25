<?php

namespace App\Models;

require __DIR__ . '/../../vendor/autoload.php';
// require __DIR__ . '/ConnectDB.php';
// use App\Models\ConnectDB;

error_reporting(E_ALL);
ini_set('display_errors', 1);

// const DEFAULT_COUNT_BOOKS = 20;
// const LIMIT = 8;
// const OFFSET = 1;
// $offset = 8;

//echo getCountRowsBooks();
// $db = ConnectDB::getInstance();

function getDataBooks($limit, $offset, $searchType = null, $input = null)
{
    // global $db;
    $db = ConnectDB::getInstance();
    $query = (file_get_contents(__DIR__ . '/../../db/select_books.sql'));

    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $limit, $offset);

    if ($stmt->execute()) {
        // $dataBooksArray = [];
        $result = $stmt->get_result();

        $dataBooksArray = $result->fetch_all(MYSQLI_ASSOC);

        return $dataBooksArray;
    }

    return false;
};

function getCountRowsBooks()
{
   // global $db;
    $db = ConnectDB::getInstance();

    // $db = ConnectDB::getInstance();
    $query = (file_get_contents(__DIR__ . '/../../db/count_rows_books_table.sql'));
    // var_dump($query);

    $result = $db->query($query);

    $row = $result->fetch_row();
    return isset($row[0]) ? (int)$row[0] : false;
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
