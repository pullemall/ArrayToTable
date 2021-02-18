<?php
spl_autoload_register(function($class){
    $path = explode(DIRECTORY_SEPARATOR, $class);

    if ($path[1] == "Model") {
        require_once 'model' . DIRECTORY_SEPARATOR . $path[2] . '.php';
    }
    else if ($path[1] == "Utils") {
        require_once 'utils' . DIRECTORY_SEPARATOR . $path[2] . '.php';
    }
    else if ($path[1] == "Views") {
        require_once 'views' . DIRECTORY_SEPARATOR . $path[2] . '.php';
    }
});