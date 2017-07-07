<?php

use USaq\StaticProxy\StaticProxy;

// Composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Load environment variables
try {
    $dotEnv = new \Dotenv\Dotenv(__DIR__ . '/../');
    $dotEnv->load();
} catch (\Dotenv\Exception\InvalidPathException $e) {
    //
}

require __DIR__ . '/container/container.php';

// Prepare Static Proxies
StaticProxy::setStaticProxyApplication($app);
