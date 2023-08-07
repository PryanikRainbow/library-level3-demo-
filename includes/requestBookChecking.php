<?php



// const REQUEST_BOOK = '/views/book-page.php?id=';
// echo getBookID('/views/book-page.php?id=0907888lk');

// function getBookID($requestURI)
// {
//     // if (strpos($requestURI, REQUEST_BOOK) === 0) {
//         $idStartPosition = strlen(REQUEST_BOOK);

//         $id = substr($requestURI, $idStartPosition);
//         if (is_numeric($id)) {
//             return (int)$id;
//         }
//     // }
//     return false;
// }
$param;

function route($pathURI, $requestURI){
    if ($pathURI === $requestURI) return true;
    else if (strpos($requestURI, $pathURI) === 0) {
      global $param; 
      $argStartPosition = strlen($pathURI);
      $param = substr($requestURI, $argStartPosition);

      return true;
    }
    return false;
}

function getParam() {
    global $param;
    return $param;
}

function isNumParam() {
    global $param;
    return is_numeric($param);
}
