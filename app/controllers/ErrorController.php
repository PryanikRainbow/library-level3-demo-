<?php

echo "error";
echo json_encode(['error' => 'Bad Request']);
http_response_code(400);
// require_once __DIR__ . '/../../views/error.php';
