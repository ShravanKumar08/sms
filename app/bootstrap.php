<?php

if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}
require BASE_PATH . '/config/config.php';
require BASE_PATH . '/app/helpers.php';

spl_autoload_register(function ($class) {
    $paths = [
        BASE_PATH . '/app/core/',
        BASE_PATH . '/app/models/',
        BASE_PATH . '/app/controllers/'
    ];

    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require $file;
            return;
        }
    }
});

Session::start();

if (!file_exists(BASE_PATH . '/storage/app.sqlite')) {
    require BASE_PATH . '/app/models/Seed.php';
    Seed::run();
}
