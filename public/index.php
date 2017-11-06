<?php
date_default_timezone_set('Europe/Madrid');
$local = setlocale(LC_TIME, 'es_ES.utf8');

// To help the built-in PHP dev server, check if the request was actually for
// something which should probably be served as a static file
if (PHP_SAPI === 'cli-server' && $_SERVER['SCRIPT_FILENAME'] !== __FILE__) {
    return false;
}

// Bootstrap app
/** @var \Slim\App $app */
$app = require __DIR__ . '/../config/bootstrap.php';

// Run!
$app->run();
