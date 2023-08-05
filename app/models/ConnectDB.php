<?php

namespace app\models;

use Exception;

class ConnectDB
{
    private static $connect = null;

    public const SERVER_NAME = '127.0.0.1';
    public const USER_NAME = 'anya';
    public const PASSWORD = '12345678';

    private function __construct()
    {

    }

    private function __clone()
    {

    }

    public static function getInstance()
    {
        if (self::$connect == null) {

            try {
                self::$connect = new \mysqli(self::SERVER_NAME, self::USER_NAME, self::PASSWORD);
                self::$connect->multi_query(file_get_contents(__DIR__ . ' /../../db/db_books.sql'));
                while (self::$connect->next_result()) {;} //?
            } catch (Exception $e) {
                echo $e->getMessage();
            }

            return self::$connect;
        }
    }

    public static function closeDB(){
        if (self::$connect !== null) {
            self::$connect->close();
            self::$connect = null; 
        } 
    }
}
