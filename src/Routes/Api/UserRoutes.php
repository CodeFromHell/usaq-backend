<?php

namespace USaq\Routes\Api;

use USaq\App\Application;
use USaq\Middleware\AuthenticationMiddleware;
use USaq\Routes\RoutesProviderInterface;

/**
 * Provide routes for User resource.
 */
class UserRoutes implements RoutesProviderInterface
{
    /**
     * @inheritdoc
     */
    public function registerRoutes(Application $app): void
    {
        $app->group('/user', function () use ($app) {
            $app->post('/register', ['USaq\Controller\AuthenticationController', 'register']);
            $app->post('/login', ['USaq\Controller\AuthenticationController', 'login']);
        });

        $app->group('/user', function () use ($app) {
            $app->post('/logout', ['USaq\Controller\AuthenticationController', 'logout']);
            $app->get('/{identifier:[0-9]+}/list', ['USaq\Controller\UserController', 'list']);
        })->add(AuthenticationMiddleware::class);
    }
}
