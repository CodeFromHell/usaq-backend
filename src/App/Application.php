<?php

namespace USaq\App;

use DI\Bridge\Slim\App;
use DI\ContainerBuilder;

class Application extends App
{
    public function __construct()
    {
        parent::__construct();

        $this->bootstrap();
    }

    /**
     * Initialize application.
     */
    protected function bootstrap()
    {
        MiddlewareInitializer::initialize($this);
        RoutesInitializer::initialize($this);
    }

    /**
     * Configure dependency container.
     *
     * @param ContainerBuilder $builder
     */
    protected function configureContainer(ContainerBuilder $builder)
    {
        /* Configuration definitions */
        $builder->addDefinitions(__DIR__ . "/../../config/configuration.php");

        /* DIC default definitions */
        $builder->addDefinitions(__DIR__ . "/DependencyInjection/definitions/di-definition.php");

        $environment = getenv('APP_ENV');
        if ($environment) {
            $builder->addDefinitions(__DIR__ . "/DependencyInjection/definitions/di-definition.{$environment}.php");
        }
    }
}
