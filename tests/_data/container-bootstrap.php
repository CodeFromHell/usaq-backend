<?php

use USaq\App\Application;
use USaq\StaticProxy\StaticProxy;
use USaq\StaticProxy\App;

require_once __DIR__ . '/../../vendor/autoload.php';

try {
    $dotEnv = new \Dotenv\Dotenv(__DIR__);
    $dotEnv->load();
} catch (\Dotenv\Exception\InvalidPathException $e) {
    //
}

/* *********************************************** */
/* *        Register Service Providers           * */
/* *********************************************** */
// Register service providers for applications
Application::registerServiceProviders([
    \USaq\Provider\SettingsProvider::class,
    \USaq\Provider\LoggerProvider::class,
    \USaq\Provider\DoctrineProvider::class
]);

// Instantiate the app
$app = new Application();

/* *********************************************** */
/* *        Register Global Middlewares          * */
/* *********************************************** */
// Register global application middlewares
// Acts as LIFO queue, last added midleware is processed first
//$app->registerMiddlewares([]);

/* *********************************************** */
/* *               Register Routes               * */
/* *********************************************** */
$app->registerRoutes([
    \USaq\Routes\UserRoutes::class
]);

// Prepare Static Proxies
StaticProxy::setStaticProxyApplication($app);

return App::getContainer();
