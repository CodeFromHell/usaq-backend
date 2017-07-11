<?php

namespace USaq\Provider;

use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Psr\Container\ContainerInterface;
use function DI\env;
use function DI\get;
use function DI\object;
use function DI\string;

/**
 * Provide configuration for Doctrine service.
 */
class DoctrineProvider implements ServiceProviderInterface
{
    /**
     * @inheritDoc
     */
    public function registerServices(): array
    {
        return [
            /* Persistence */
            'database.paths' => [
                string("{dir.src.entities}/config")
            ],
            'database.parameters' => [
                'url' => env('DATABASE_URL')
            ],

            'dir.cache.metadata' => string('{dir.cache}/doctrine/metadata'),

            'dir.cache.proxies' => string('{dir.cache}/doctrine/proxies'),

            'persistence' => get(EntityManager::class),

            'cache' => object(FilesystemCache::class)->constructor(get('dir.cache.metadata')),

            EntityManager::class => function (ContainerInterface $c) {
                $isDevMode = getenv('APP_ENV') !== 'production';

                $paths = [
                    $c->get('dir.src.entities')
                ];

                if ($isDevMode) {
                    $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
                } else {
                    $config = Setup::createAnnotationMetadataConfiguration(
                        $paths,
                        $isDevMode,
                        $c->get('dir.cache.proxies'),
                        $c->get('cache')
                    );
                }

                return EntityManager::create($c->get('database.parameters'), $config);
            },
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
