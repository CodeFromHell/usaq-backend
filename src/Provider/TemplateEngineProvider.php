<?php

namespace USaq\Provider;

use function DI\object;
use USaq\Templating\EngineInterface;
use USaq\Templating\Fractal\FractalEngine;

class TemplateEngineProvider implements ServiceProviderInterface
{
    /**
     * @inheritDoc
     */
    public function registerServices(): array
    {
        return [
            EngineInterface::class => object(FractalEngine::class)
        ];
    }

    /**
     * @inheritDoc
     */
    public function registerServicesDevelopment(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function registerServicesTest(): array
    {
        return [];
    }
}