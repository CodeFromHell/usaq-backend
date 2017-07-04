<?php

use USaq\Facade\Facade;

require_once __DIR__ . '/../vendor/autoload.php';

try {
    $dotEnv = new \Dotenv\Dotenv(__DIR__ . '/../config/');
    $dotEnv->load();
} catch (\Dotenv\Exception\InvalidPathException $e) {
    //
}

// Instantiate the app
$app = new \USaq\App\Application();

// Prepare Facades
Facade::setFacadeApplication($app);
