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
        string("{dir.src.entities}/config")
    ],
    'database.parameters' => [
        'url' => env('DATABASE_URL')
    ],

    \Doctrine\ORM\EntityManager::class => function (ContainerInterface $c) {
        $isDevMode = getenv('APP_ENV') === 'development';

        $config = \Doctrine\ORM\Tools\Setup::createConfiguration($isDevMode);

        $namespaces = [
            $c->get('dir.src.entities') . '/config' => 'USaq\Model\Entity'
        ];

        $driver = new \Doctrine\ORM\Mapping\Driver\SimplifiedYamlDriver($namespaces);
        $config->setMetadataDriverImpl($driver);

        return \Doctrine\ORM\EntityManager::create($c->get('database.parameters'), $config);
    },
    'persistence' => get(\Doctrine\ORM\EntityManager::class),

    /* Logger configuration */
    'logger.max-log-files' => 20,

    StreamHandler::class => object()->constructor(string('{dir.logs}/logs.log')),
    RotatingFileHandler::class => object()->constructor(string('{dir.logs}/logger.log'), get('logger.max-log-files')),

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
    }
];
