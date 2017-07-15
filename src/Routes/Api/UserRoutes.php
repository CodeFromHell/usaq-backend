<?php

namespace USaq\Routes\Api;

use USaq\App\Application;
use USaq\Middleware\AuthenticationMiddleware;
use USaq\Middleware\PermissionMiddleware;
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
            $app->post('/logout', ['USaq\Controller\AuthenticationController', 'logout'])->add(AuthenticationMiddleware::class);
        });

        $app->group('/user', function () use ($app) {
            $app->get('/{identifier:[0-9]+}/all', ['USaq\Controller\UserController', 'showAllUsers']);
            $app->get('/{identifier:[0-9]+}/friends', ['USaq\Controller\UserController', 'showUserFriends']);
            $app->post('/{identifier:[0-9]+}/friends/add', ['USaq\Controller\UserController', 'addUserFriend']);
            $app->post('/{identifier:[0-9]+}/friends/remove', ['USaq\Controller\UserController', 'removeUserFriend']);
        })->add(PermissionMiddleware::class)->add(AuthenticationMiddleware::class);
    }
}
