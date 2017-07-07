<?php

use USaq\App\Application;
use USaq\StaticProxy\StaticProxy;

/* *********************************************** */
/* *        Register Service Providers           * */
/* *********************************************** */
// Register service providers for applications
Application::registerServiceProviders([
    \USaq\Provider\SettingsProvider::class,
    \USaq\Provider\LoggerProvider::class,
    \USaq\Provider\DoctrineProvider::class,
    \USaq\Provider\MiddlewareProvider::class
]);

// Instantiate the app
$app = new Application();

/* *********************************************** */
/* *        Register Global Middlewares          * */
/* *********************************************** */
// Register global application middlewares
// Acts as LIFO queue, last added midleware is processed first
/*$app->registerMiddlewares([
    \Tuupola\Middleware\Cors::class,
    \Gofabian\Negotiation\NegotiationMiddleware::class
]);*/

/* *********************************************** */
/* *               Register Routes               * */
/* *********************************************** */
$app->registerRoutes([
    \USaq\Routes\UserRoutes::class
]);

// Prepare Static Proxies
StaticProxy::setStaticProxyApplication($app);

return $app->getContainer();