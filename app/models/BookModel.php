<?php

namespace app\models;

require_once __DIR__ . '/ConnectDB.php';
use app\models\ConnectDB;


error_reporting(E_ALL);
ini_set('display_errors', 1);

// const DEFAULT_COUNT_BOOKS = 20;
// Щось тут рне так :)

// echo "book";
// if (getDataBook(7) !== false) {
//     echo "Yes!";
// } else {
//     echo "not found!";
// }


    function getDataBook($id)
    {
        $db = ConnectDB::getInstance();
        $query = file_get_contents(__DIR__ . '/../../db/select_book_by_ID.sql');
    
        $stmt = $db->prepare($query);
        $stmt->bind_param("i", $id);
    
        if ($stmt->execute()) {
            $result = $stmt->get_result()->fetch_assoc();
    
            if ($result) return $result; 
        }
    
        return false; 
    }

    function  incrementWantsCounter($id){
        $db = ConnectDB::getInstance();
        $query = file_get_contents(__DIR__ . '/../../db/update_wantsCounter.sql');
    
        $stmt = $db->prepare($query);
        $stmt->bind_param("i", $id);
    
        if ($stmt->execute()) {return true;
        }
    
        return false;  
    }
