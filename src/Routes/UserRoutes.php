<?php

namespace USaq\Routes;

use USaq\App\Application;
use USaq\Middleware\AuthenticationMiddleware;

class UserRoutes implements RoutesProviderInterface
{
    /**
     * @inheritDoc
     */
    public function registerRoutes(Application $app)
    {
        $app->group('/user', function () use ($app) {
            $app->post('/register', ['USaq\Controller\AuthenticationController', 'register']);
            $app->post('/login', ['USaq\Controller\AuthenticationController', 'login']);
        });

        $app->group('/user', function () use ($app) {
            $app->post('/logout', ['USaq\Controller\AuthenticationController', 'logout']);
        })->add(AuthenticationMiddleware::class);
    }
}
