<?php

namespace USaq\Facade;

use Psr\Container\ContainerInterface;

/**
 * Container Facade.
 *
 * @method static mixed get($id)
 * @method static bool has($id)
 */
class Container extends Facade
{
    /**
     * @return ContainerInterface
     */
    protected static function getFacadeAccessor()
    {
        return static::$app->getContainer();
    }
}