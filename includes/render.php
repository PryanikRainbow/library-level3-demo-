<?php

function render($template, $data = null)
{
    if ($data != null) {
    extract($data);
    // print_r($data);
}
    ob_start();
    require $template;
    $output = ob_get_clean();

    echo $output;
}