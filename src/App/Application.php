<?php

namespace USaq\App;

use DI\Bridge\Slim\App;
use DI\ContainerBuilder;
use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;

class Application extends App
{
    public function __construct()
    {
        parent::__construct();

        $this->initialize();
    }

    public static function bootstrap()
    {
        require_once __DIR__ . '/../../vendor/autoload.php';

        try {
            $dotEnv = new Dotenv(__DIR__ . '/../../');
            $dotEnv->load();
        } catch (InvalidPathException $e) {
            //
        }

        // Return instantiated the app
        return new self();
    }


    /**
     * Initialize application.
     */
    protected function initialize()
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
        $builder->addDefinitions(__DIR__ . "/DependencyInjection/di-definition.php");

        $environment = getenv('APP_ENV');
        if ($environment) {
            $builder->addDefinitions(__DIR__ . "/DependencyInjection/di-definition.{$environment}.php");
        }
    }
}
