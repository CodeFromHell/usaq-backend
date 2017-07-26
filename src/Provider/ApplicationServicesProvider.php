<?php

namespace USaq\Provider;

use function DI\get;
use function DI\object;
use function DI\string;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\PsrLogMessageProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use USaq\App\ServiceProvider\ServiceProviderInterface;
use USaq\Templating\EngineInterface;
use USaq\Templating\Fractal\FractalEngine;

/**
 * Provide logger service configuration.
 */
class ApplicationServicesProvider implements ServiceProviderInterface
{
    /**
     * @inheritdoc
     */
    public function registerServices(): array
    {
        return [
            /* Folders configuration */
            'dir.base' => __DIR__ . '/../../',
            'dir.cache' => string('{dir.base}/cache'),
            'dir.config' => string('{dir.base}/config'),
            'dir.docs' => string('{dir.base}/docs'),
            'dir.src' => string('{dir.base}/src'),
            'dir.src.entities' => string('{dir.src}/Model/Entity'),
            'dir.storage' => string('{dir.base}/var'),
            'dir.var' => get('dir.storage'),
            'dir.database' => string('{dir.storage}/database'),
            'dir.logs' => string('{dir.storage}/logs'),

            /* Logger configuration */
            'logger.max-log-files' => 20,

            StreamHandler::class => object()->constructor(string('{dir.logs}/logs.log')),
            RotatingFileHandler::class => object()->constructor(string('{dir.logs}/logger.log'), get('logger.max-log-files')),

            'logger.handlers' => [
                get(RotatingFileHandler::class)
            ],

            'logger' => get(LoggerInterface::class),

            LoggerInterface::class => function (ContainerInterface $container) {
                $logger = new Logger('REQUEST');
                foreach ($container->get('logger.handlers') as $handlers) {
                    $logger->pushHandler($handlers);
                }
                $logger->pushProcessor(new PsrLogMessageProcessor());

                return $logger;
            },

            /**
             * Rendering engine
             */
            EngineInterface::class => object(FractalEngine::class)
        ];
    }

    /**
     * @inheritdoc
     */
    public function registerServicesDevelopment(): array
    {
        return [
            /* Logger Dev configuration */
            StreamHandler::class => object()->constructor(string('{dir.logs}/logs-dev.log')),
            RotatingFileHandler::class => object()->constructor(string('{dir.logs}/logger-dev.log'), get('logger.max-log-files'))
        ];
    }

    /**
     * @inheritdoc
     */
    public function registerServicesTest(): array
    {
        return [];
    }
}
