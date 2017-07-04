<?php

use USaq\App\Application;
use USaq\Facade\Facade;
use USaq\Facade\App;

require_once __DIR__ . '/../../vendor/autoload.php';

try {
    $dotEnv = new \Dotenv\Dotenv(__DIR__ . '/../../config/');
    $dotEnv->load();
} catch (\Dotenv\Exception\InvalidPathException $e) {
    //
}

$app = new Application();

Facade::setFacadeApplication($app);

return App::getContainer();
