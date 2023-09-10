<?php

namespace App\Controllers;

abstract class Controller
{
    public abstract function defineController($obj, $params = null);
}
