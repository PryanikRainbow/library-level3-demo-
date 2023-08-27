<?php

const SEARCH_OPTIONS =  [
    "title" => "Название",
    "author" => "Автор",
     "year" => "Год"
];

const LIMIT = 20;
const OFFSET_DEFAULT = 10;
 
class CounterType {
    const WANTS = 'wants';
    const VIEWS = 'views';
}

class SearchType {
    const TITLE = 'title';
    const AUTHOR = 'author';
    const YEAR = 'author';
}

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

function isAllBooks($params)
{
    return  count($params) === 1 && isset($params['offset']) && is_numeric($params['offset']);
}

function isBooksBySearch($params)
{
    //подумать, що робити, якщо пошук пустий або тип пошуку
    return count($params) === 3 &&
           isset($params['select-by']) &&
           in_array($params['select-by'], array_keys(SEARCH_OPTIONS)) &&
           isset($params['search-book']) &&
           isset($params['offset']) &&
           is_numeric($params['offset']);
}

function searchMessage($params, $countBooks) {
    if(isBooksBySearch($params)){
        if($params['search-book'] !== "")
            return "Результаты по запросу {$params['search-book']}. Найдено: $countBooks";
            else return "Запрос поиска не содержит данных.";
    }

    return false;
}

function isValidOffset($offset, $countBooks){
    return $offset >= 0 && $offset <= $countBooks;

}

function isFirstBooksPage($pre, $next){
    return $pre === 0 && $next === OFFSET_DEFAULT;
}

function isLastBooksPage($countBooks, $next){
    return $next >= $countBooks;

    //  if($countBooks<LIMIT) return true;
    //  echo $countBooks;

    //  $countPages = $countBooks / LIMIT;
    //  $countPages = ($countBooks % LIMIT) === 0 ? $countPages : (int)$countPages + 1;
    //  $maxOffset = $countPages * OFFSET_DEFAULT;
 
    //  return $next > $maxOffset? true : false;
}

function e($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

