<?php

namespace USaq\Provider;

use function DI\get;
use function DI\object;
use function DI\string;
use USaq\App\Handler\ApiError;
use USaq\App\Handler\NotAllowedError;
use USaq\App\Handler\NotFoundError;

class SettingsProvider implements ServiceProviderInterface
{
    /**
     * @inheritDoc
     */
    public function registerServices(): array
    {
        return [
            'dir.base' => __DIR__ . '/../..',
            'dir.cache' => string('{dir.base}/cache'),
            'dir.config' => string('{dir.base}/config'),
            'dir.docs' => string('{dir.base}/docs'),
            'dir.logs' => string('{dir.base}/logs'),
            'dir.src' => string('{dir.base}/src'),
            'dir.src.entities' => string('{dir.src}/Model/Entity'),
            'dir.storage' => string('{dir.base}/storage'),

            'settings.determineRouteBeforeAppMiddleware' => false,
            'settings.displayErrorDetails' => false,

            // Handlers
            'errorHandler' => get('phpErrorHandler'),
            'phpErrorHandler' => object(ApiError::class)->constructor(get('logger')),
            'notFoundHandler' => object(NotFoundError::class),
            'notAllowedHandler' => object(NotAllowedError::class)
        ];
    }

    /**
     * @inheritDoc
     */
    public function registerServicesDevelopment(): array
    {
        return [
            'settings.displayErrorDetails' => true,
        ];
    }

    /**
     * @inheritDoc
     */
    public function registerServicesTest(): array
    {
        return [];
    }
}
