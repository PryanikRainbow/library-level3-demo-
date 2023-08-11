<?php

const LIMIT = 1;
const OFFSET_DEFAULT = 1;
// $offset = 1;

// function $currentOffset($offset){

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

function e($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

