<?php

if (!defined('APP_NAME')) {
    define('APP_NAME', 'PG Management System');
}
if (!defined('APP_ENV')) {
    define('APP_ENV', 'development');
}
if (!defined('PUBLIC_PATH')) {
    define('PUBLIC_PATH', dirname(__DIR__) . '/public');
}
if (!defined('ASSETS_PATH')) {
    define('ASSETS_PATH', PUBLIC_PATH . '/assets');
}
if (!defined('DB_DSN')) {
    define('DB_DSN', getenv('DB_DSN') ?: 'sqlite:' . dirname(__DIR__) . '/storage/app.sqlite');
}
if (!defined('DB_USERNAME')) {
    define('DB_USERNAME', getenv('DB_USERNAME') ?: '');
}
if (!defined('DB_PASSWORD')) {
    define('DB_PASSWORD', getenv('DB_PASSWORD') ?: '');
}

return [
    'app_name' => APP_NAME,
    'base_path' => dirname(__DIR__),
    'public_path' => PUBLIC_PATH,
    'asset_url' => '/assets',
    'default_role' => 'student',
];
