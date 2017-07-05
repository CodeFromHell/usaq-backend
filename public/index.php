<?php

use USaq\StaticProxy\App;

// To help the built-in PHP dev server, check if the request was actually for
// something which should probably be served as a static file
if (PHP_SAPI === 'cli-server' && $_SERVER['SCRIPT_FILENAME'] !== __FILE__) {
    return false;
}

// Bootstrap app
require __DIR__ . '/../app/bootstrap.php';

// Run!
App::run();
