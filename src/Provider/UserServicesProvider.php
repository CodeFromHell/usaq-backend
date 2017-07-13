<?php

namespace USaq\Provider;

use function DI\object;
use USaq\Services\UserServices\AuthenticationService;
use USaq\Services\UserServices\AuthenticationServiceDb;
use USaq\Services\UserServices\UserService;
use USaq\Services\UserServices\UserServiceDb;

class UserServicesProvider implements ServiceProviderInterface
{
    /**
     * @inheritDoc
     */
    public function registerServices(): array
    {
        return [
            UserService::class => object(UserServiceDb::class),
            AuthenticationService::class => object(AuthenticationServiceDb::class)
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