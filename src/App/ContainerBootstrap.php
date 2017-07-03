<?php

require_once __DIR__ . '/../../vendor/autoload.php';

try {
    $dotEnv = new \Dotenv\Dotenv(__DIR__ . '/../../config/');
    $dotEnv->load();
} catch (\Dotenv\Exception\InvalidPathException $e) {
    //
}

// Instantiate the app and return internal container
$app = new \USaq\App\Application();

return $app->getContainer();
