<?php
/**
 * Created by IntelliJ IDEA.
 * User: RJ Corchero
 * Date: 05/07/2017
 * Time: 21:02
 */

namespace USaq\Provider;

use function DI\string;
use function DI\get;
use function DI\env;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\SimplifiedYamlDriver;
use Doctrine\ORM\Tools\Setup;
use Psr\Container\ContainerInterface;

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

            'persistence' => get(EntityManager::class),

            EntityManager::class => function (ContainerInterface $c) {
                $isDevMode = getenv('APP_ENV') === 'development';

                $config = Setup::createConfiguration($isDevMode);

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