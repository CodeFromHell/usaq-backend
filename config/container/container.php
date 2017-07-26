<?php
/**
 * Bootstrap PSR-11 container and return it.
 *
 * Must return application in keys 'app' and '\Slim\App::class' as alias of 'app'.
 */

use USaq\App\Application;
use USaq\StaticProxy\StaticProxy;
use USaq\App\ServiceProvider\ServiceProviderManager;

/* *********************************************** */
/* *        Register Services Providers           * */
/* *********************************************** */
// Register service providers for applications
$serviceManager = new ServiceProviderManager();

$serviceProviders = [
    new \USaq\Provider\ApplicationServicesProvider(),
    new \USaq\Provider\PersistenceProvider(),
    new \USaq\Provider\MiddlewareProvider(),
    new \USaq\Provider\UserServicesProvider()
];

$serviceManager->addServiceProviders($serviceProviders);

// Instantiate the app
$app = new Application($serviceManager);

/* *********************************************** */
/* *        Register Global Middlewares          * */
/* *********************************************** */
// Register global application middlewares
// Acts as LIFO queue, last added midleware is processed first
$app->add(\Tuupola\Middleware\Cors::class);
$app->add(\Gofabian\Negotiation\NegotiationMiddleware::class);

/* *********************************************** */
/* *               Register Routes               * */
/* *********************************************** */
include __DIR__ . '/../routes/api.routes.php';

// Prepare Static Proxies
StaticProxy::setStaticProxyApplication($app);

return $app->getContainer();