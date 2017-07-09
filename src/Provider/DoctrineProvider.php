<?php

namespace USaq\Provider;

use function DI\object;
use function DI\string;
use function DI\get;
use function DI\env;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\SimplifiedYamlDriver;
use Doctrine\ORM\Tools\Setup;
use Psr\Container\ContainerInterface;

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

                if ($isDevMode) {
                    $config = Setup::createConfiguration($isDevMode);
                } else {
                    $config = Setup::createConfiguration($isDevMode, $c->get('dir.cache.proxies'), $c->get('cache'));
                }

                $namespaces = [
                    $c->get('dir.src.entities') . '/config' => 'USaq\Model\Entity'
                ];

                $driver = new SimplifiedYamlDriver($namespaces);
                $config->setMetadataDriverImpl($driver);

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
