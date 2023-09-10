<?php

const SEARCH_OPTIONS =  [
    "title" => "Название",
    "author" => "Автор",
    "year" => "Год"
];

const LIMIT = 20;
const OFFSET_DEFAULT = 10;
const LIMIT_TABLE = 10;
const OFFSET_TABLE_DEFAULT = 10;

class CounterType
{
    public const WANTS = 'wants';
    public const VIEWS = 'views';
}

// class SearchType
// {
//     public const TITLE = 'title';
//     public const AUTHOR = 'author';
//     public const YEAR = 'author';
// }

function render($template, $data = null)
{
    if ($data != null) {
        extract($data);
        //   print_r($data);
    }
    ob_start();
    require $template;
    $output = ob_get_clean();

    echo $output;
}

// function isAllBooks($params)
// {
//     return  count($params) === 1 && isset($params['offset']) && is_numeric($params['offset']);
// }

function isBooksBySearch($params)
{
    return count($params) === 3 &&
           isset($params['select-by']) &&
           in_array($params['select-by'], array_keys(SEARCH_OPTIONS)) &&
           isset($params['search-book']) &&
           isset($params['offset']) &&
           is_numeric($params['offset']);
}

function searchMessage($params, $countBooks)
{
    if(isBooksBySearch($params)) {
        if($params['search-book'] !== "") {
            return "Поиск по: " . SEARCH_OPTIONS[$_GET['select-by']] . 
            ". Результаты по запросу: {$params['search-book']}. Найдено: $countBooks";
        } else {
            return "Запрос поиска не содержит данных.";
        }
    }

    return false;
}

// function isOpenBookInfo($params){
//     // var_dump($params);
//     return count($params) === 3 &&
//     isset($params['action']) && $params['action'] === 'view' &&
//     isset($params['id']) &&
//     is_numeric($params['id']) &&
//     isset($params['page']) && 
//     is_numeric($params['page']);
// }

// $adminModel->checkExistsID($params['id']) &&

function isValidOffset($offset, $countBooks)
{
    return $offset >= 0 && $offset <= $countBooks;
}

function isFirstBooksPage($pre, $next)
{
    return $pre === 0 && $next === OFFSET_DEFAULT;
}

function isLastBooksPage($countBooks, $next)
{
    return $next >= $countBooks;
}

function e($value)
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
