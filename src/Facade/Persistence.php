<?php

namespace USaq\Facade;

/**
 * Persistence Layer Facade.
 *
 * @method static getRepository(string $entityClass)
 * @method static persist($entity)
 * @method static flush()
 */
class Persistence extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'persistence';
    }
}