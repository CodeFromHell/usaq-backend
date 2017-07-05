<?php

namespace USaq\App;

use DI\Bridge\Slim\App;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;
use USaq\Provider\ServiceProviderInterface;
use USaq\Routes\RoutesProviderInterface;

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

        foreach (static::$serviceProviders as $serviceProviderClassName) {
            $serviceProvider = new $serviceProviderClassName();

            if (!$serviceProvider instanceof ServiceProviderInterface) {
                throw new \RuntimeException('Not implements ServiceProvider interface');
            }

            $builder->addDefinitions($serviceProvider->registerServices());

            if ($environment == 'development')
                $builder->addDefinitions($serviceProvider->registerServicesDevelopment());
            elseif ($environment == 'test')
                $builder->addDefinitions($serviceProvider->registerServicesTest());
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
            if (!is_callable($middleware) && !is_string($middleware))
                throw new \RuntimeException('Not a callable or string for container');

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
        $this->group('/api', function () use ($routesProviders) {
           foreach ($routesProviders as $routeProviderClassName) {
               $routeProvider = new $routeProviderClassName();
               if (!$routeProvider instanceof RoutesProviderInterface)
                   throw new \RuntimeException('Not implements RoutesProviderInterface');

               $routeProvider->registerRoutes($this);
           }
        });
    }
}
