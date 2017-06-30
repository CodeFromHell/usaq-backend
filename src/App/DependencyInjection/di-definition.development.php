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

return [
    /* Logger configuration */
    'maxLogFiles' => 20,

    StreamHandler::class => object()->constructor(string('{dir.logs}/logs-dev.log')),
    RotatingFileHandler::class => object()->constructor(string('{dir.logs}/logger-dev.log'), get('maxLogFiles')),

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