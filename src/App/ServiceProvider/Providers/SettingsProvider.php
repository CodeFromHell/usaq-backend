<?php

namespace USaq\App\ServiceProvider\Providers;

use function DI\get;
use function DI\object;
use function DI\string;
use USaq\App\Handler\ApiError;
use USaq\App\Handler\NotAllowedError;
use USaq\App\Handler\NotFoundError;
use USaq\App\ServiceProvider\ServiceProviderInterface;

/**
 * Provides basic settings information.
 */
class SettingsProvider implements ServiceProviderInterface
{
    /**
     * @inheritdoc
     */
    public function registerServices(): array
    {
        return [
            'settings.determineRouteBeforeAppMiddleware' => true,
            'settings.displayErrorDetails' => false,

            // Handlers
            'errorHandler' => get('phpErrorHandler'),
            'phpErrorHandler' => object(ApiError::class)->constructor(get('logger')),
            'notFoundHandler' => object(NotFoundError::class),
            'notAllowedHandler' => object(NotAllowedError::class)
        ];
    }

    /**
     * @inheritdoc
     */
    public function registerServicesDevelopment(): array
    {
        return [
            'settings.displayErrorDetails' => true,
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
