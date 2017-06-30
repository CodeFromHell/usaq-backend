<?php

// To help the built-in PHP dev server, check if the request was actually for
// something which should probably be served as a static file
if (PHP_SAPI === 'cli-server' && $_SERVER['SCRIPT_FILENAME'] !== __FILE__) {
    return false;
}

require __DIR__ . '/../vendor/autoload.php';

try {
    $dotEnv = new Dotenv\Dotenv(__DIR__ . '/../');
    $dotEnv->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

// Instantiate the app
$app = new \USaq\App\Application();

// Run!
$app->run();
