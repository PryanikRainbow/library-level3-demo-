<?php

const SERVER_NAME = '127.0.0.1';
const USER_NAME = 'anya';
const PASSWORD = '12345678';

$conn = new mysqli(SERVER_NAME, USER_NAME, PASSWORD);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->multi_query(file_get_contents(__DIR__ . '/db_books.sql'));

$conn->close(); 




