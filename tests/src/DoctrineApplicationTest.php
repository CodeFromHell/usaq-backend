<?php

namespace Test\USaq;

use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;
use USaq\App\Application;

/**
 * Class DoctrineApplicationTest.
 *
 * Provides static accessors for EntityManager.
 *
 * @package Test\USaq
 */
class DoctrineApplicationTest extends Application
{
    private static $app;

    public function __construct()
    {
        if (self::$app) {
            return self::$app;
        }

        parent::__construct();
    }

    protected function configureContainer(ContainerBuilder $builder)
    {
        parent::configureContainer($builder);

        $builder->addDefinitions([
            \Slim\App::class => function (ContainerInterface $container) {
                return self::$app;
            }
        ]);
    }


    public static function getEntityManager()
    {
        if (!self::$app) {
            self::$app = new self();
        }

        return self::$app->getContainer()->get('persistence');
    }

    public static function getAppContainer()
    {
        if (!self::$app) {
            self::$app = new self();
        }

        return self::$app->getContainer();
    }
}