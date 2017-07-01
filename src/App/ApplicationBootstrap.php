<?php

require_once __DIR__ . '/../../vendor/autoload.php';

try {
    $dotEnv = new \Dotenv\Dotenv(__DIR__ . '/../../config/');
    $dotEnv->load();
} catch (\Dotenv\Exception\InvalidPathException $e) {
    //
}

// Instantiate the app
return new \USaq\App\Application();
