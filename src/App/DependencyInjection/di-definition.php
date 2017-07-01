<?php

use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\PsrLogMessageProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use function DI\get;
use function DI\object;
use function DI\string;
use function DI\env;

return [

    /* Persistence */
    'database.paths' => [
        string("{dir.base}/src/Model")
    ],
    'database.parameters' => [
        'url' => env('DATABASE_URL')
    ],

    \Doctrine\ORM\EntityManager::class => function(ContainerInterface $c) {
        $isDevMode = getenv('APP_ENV') === 'development';

        $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration($c->get('database.paths'), $isDevMode);
        return \Doctrine\ORM\EntityManager::create($c->get('database.parameters'), $config);
    },
    'persistence' => get(\Doctrine\ORM\EntityManager::class),

    /* Logger configuration */
    'maxLogFiles' => 20,

    StreamHandler::class => object()->constructor(string('{dir.logs}/logs.log')),
    RotatingFileHandler::class => object()->constructor(string('{dir.logs}/logger.log'), get('maxLogFiles')),

    'logger.handlers' => [
        get(RotatingFileHandler::class)
    ],

    LoggerInterface::class => function (ContainerInterface $container) {
        $logger = new Logger('REQUEST');
        foreach ($container->get('logger.handlers') as $handlers) {
            $logger->pushHandler($handlers);
        }
        $logger->pushProcessor(new PsrLogMessageProcessor());

        return $logger;
    },
];