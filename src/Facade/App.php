<?php

namespace USaq\Facade;

/**
 * App facade.
 *
 * @method static \Psr\Container\ContainerInterface getContainer()
 * @method static \Psr\Http\Message\ResponseInterface run($silent = false)
 */
class App extends Facade
{
    /**
     * @return \Slim\App
     */
    protected static function getFacadeAccessor()
    {
        return self::$app;
    }
}