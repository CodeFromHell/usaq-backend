<?php

use USaq\StaticProxy\App;

// Composer autoloader
require_once __DIR__ . '/../../vendor/autoload.php';

// Load environment variables
try {
    $dotEnv = new \Dotenv\Dotenv(__DIR__);
    $dotEnv->load();
} catch (\Dotenv\Exception\InvalidPathException $e) {
    //
}

// Bootstrap app
require __DIR__ . '/../../app/bootstrap.php';

return App::getContainer();
