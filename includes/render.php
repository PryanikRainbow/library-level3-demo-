<?php

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

function isFirstBooksPage($pre, $next){
    return $pre === 0 && $next === OFFSET_DEFAULT;
}

function isLastBooksPage($countBooks, $next){
    $countPages = $countBooks / LIMIT;
    $countPages = ($countBooks % LIMIT) === 0 ? $countPages : (int)$countPages + 1;
    $maxOffset = $countPages * OFFSET_DEFAULT;

    return $next > $maxOffset? true : false;
}

function e($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

