<?php

namespace USaq\App;

use DI\Bridge\Slim\App;
use DI\Cache\ArrayCache;
use DI\ContainerBuilder;
use Doctrine\Common\Cache\FilesystemCache;
use USaq\App\ServiceProvider\ServiceProviderManager;

/**
 * Application class.
 */
class Application extends App
{
    /**
     * @var ServiceProviderManager | null
     */
    protected $manager;

    /**
     * Application constructor.
     *
     * @param ServiceProviderManager|null $manager
     */
    public function __construct(ServiceProviderManager $manager = null)
    {
        $this->manager = $manager;

        parent::__construct();
    }

    /**
     * Configure dependency container.
     *
     * @param ContainerBuilder $builder
     */
    protected function configureContainer(ContainerBuilder $builder)
    {
        $environment = getenv('APP_ENV');

        // Add caching for definitions
        if ($environment !== 'production') {
            $builder->setDefinitionCache(new ArrayCache());
        } else {
            $builder->setDefinitionCache(new FilesystemCache(__DIR__ . '/../../cache/container'));
        }

        if ($this->manager !== null) {
            foreach ($this->manager->getServiceProviders() as $serviceProvider) {
                $builder->addDefinitions($serviceProvider->registerServices());

                if ($environment == 'development') {
                    $builder->addDefinitions($serviceProvider->registerServicesDevelopment());
                } elseif ($environment == 'test') {
                    $builder->addDefinitions($serviceProvider->registerServicesTest());
                }
            }
        }

        $builder->addDefinitions([
            'app' => function () {
                return $this;
            },
            \Slim\App::class => \DI\get('app')
        ]);
    }
}
