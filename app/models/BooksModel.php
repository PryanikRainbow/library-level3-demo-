<?php

namespace app\models;

require_once __DIR__ . '/ConnectDB.php';
use app\models\ConnectDB;

// const DEFAULT_COUNT_BOOKS = 20;

function getDataBooks()
{
    $db = ConnectDB::getInstance();
    $dataBooks = $db->query(file_get_contents(__DIR__ . '/../../db/select_books.sql'));

    $dataBooksArray = [];

    while($row = $dataBooks->fetch_assoc()) {
        //в масив додаємо масив асоціативних масивів(або пар)
        $dataBooksArray[] = [
            "img" => $row["img"],
            "title" => $row["title"],
            "author" => $row["author"]
        ];
    }

    return $dataBooksArray;
};

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
