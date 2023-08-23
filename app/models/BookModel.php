<?php

namespace App\Models;

require_once __DIR__ . '/ConnectDB.php';
// use App\Models\ConnectDB;


error_reporting(E_ALL);
ini_set('display_errors', 1);

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

    function  incrementCounter($id, $counterType){
        $db = ConnectDB::getInstance();
        $query = file_get_contents(__DIR__ . '/../../db/update_' . $counterType . 'Counter.sql');
    
        $stmt = $db->prepare($query);
        $stmt->bind_param("i", $id);
    
        if ($stmt->execute()) {
            return true;
        }
    
        return false;  
    }

    function getCounter($id, $counterType){
        $db = ConnectDB::getInstance();
        $query = file_get_contents(__DIR__ . '/../../db/select_' . $counterType . 'Counter.sql');
        
        $stmt = $db->prepare($query);
        $stmt -> bind_param('i', $id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_row();
            if ($row) {
                return (int)$row[0]; 
            }
        } 
    }

    // function  incrementViewsCounter($id){
    //     $db = ConnectDB::getInstance();
    //     $query = file_get_contents(__DIR__ . '/../../db/update_viewsCounter.sql');
    
    //     $stmt = $db->prepare($query);
    //     $stmt->bind_param("i", $id);
    
    //     if ($stmt->execute()) {
    //         return true;
    //     }
    
    //     return false;  
    // }

    // function getViewsCounter($id){
    //     $db = ConnectDB::getInstance();
    //     $query = file_get_contents(__DIR__ . '/../../db/select_viewsCounter.sql');
        
    //     $stmt = $db->prepare($query);
    //     $stmt -> bind_param('i', $id);

    //     if ($stmt -> execute()){
    //         $result = $stmt->get_result();
    //         $row = $result->fetch_assoc();
    //         if ($row) return (int)$row['wantsCounter'];
    //     }
    //     return false; 
    // }
