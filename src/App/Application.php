<?php

namespace USaq\App;

use DI\Bridge\Slim\App;
use DI\Cache\ArrayCache;
use DI\ContainerBuilder;
use Doctrine\Common\Cache\FilesystemCache;
use Psr\Container\ContainerInterface;
use USaq\Provider\ServiceProviderInterface;
use USaq\Routes\RoutesProviderInterface;

/**
 * Application class.
 */
class Application extends App
{
    /**
     * @var string[]
     */
    protected static $serviceProviders;

    /**
     * Register applications ServiceProviders for dependency container.
     *
     * @param string[] $serviceProviders
     */
    public static function registerServiceProviders(array $serviceProviders)
    {
        static::$serviceProviders = $serviceProviders;
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

        foreach (static::$serviceProviders as $serviceProviderClassName) {
            $serviceProvider = new $serviceProviderClassName();

            if (!$serviceProvider instanceof ServiceProviderInterface) {
                throw new \RuntimeException('Not implements ServiceProvider interface');
            }

            $builder->addDefinitions($serviceProvider->registerServices());

            if ($environment == 'development') {
                $builder->addDefinitions($serviceProvider->registerServicesDevelopment());
            } elseif ($environment == 'test') {
                $builder->addDefinitions($serviceProvider->registerServicesTest());
            }
        }

        $builder->addDefinitions([
            'app' => function (ContainerInterface $c) {
                return $this;
            },
            \Slim\App::class => \DI\get('app')
        ]);
    }

    /**
     * Register application global middlewares.
     *
     * Middlewares acts as LIFO queue.
     *
     * @param mixed[] $middlewares
     */
    public function registerMiddlewares(array $middlewares)
    {
        foreach ($middlewares as $middleware) {
            if (!is_callable($middleware) && !is_string($middleware)) {
                throw new \RuntimeException('Not a callable or string for container');
            }

            $this->add($middleware);
        }
    }

    /**
     * Register routes.
     *
     * @param string[] $routesProviders
     */
    public function registerRoutes(array $routesProviders)
    {
        foreach ($routesProviders as $routeProviderClassName) {
            $routeProvider = new $routeProviderClassName();
            if (!$routeProvider instanceof RoutesProviderInterface) {
                throw new \RuntimeException('Not implements RoutesProviderInterface');
            }

            $routeProvider->registerRoutes($this);
        }
    }

    /**
     * Register api routes.
     *
     * @param string[] $routesProviders
     */
    public function registerApiRoutes(array $routesProviders)
    {
        $this->group('/api', function () use ($routesProviders) {
            $this->registerRoutes($routesProviders);
        });
    }
}
