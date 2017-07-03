<?php

// To help the built-in PHP dev server, check if the request was actually for
// something which should probably be served as a static file
if (PHP_SAPI === 'cli-server' && $_SERVER['SCRIPT_FILENAME'] !== __FILE__) {
    return false;
}

/**
 * @var \Psr\Container\ContainerInterface $container
 */
$container = require __DIR__ . '/../src/App/ContainerBootstrap.php';

/**
 * @var \Slim\App $app
 */
$app = $container->get(\Slim\App::class);

// Run!
$app->run();
