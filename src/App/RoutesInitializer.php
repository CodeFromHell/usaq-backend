<?php

namespace USaq\App;

class RoutesInitializer
{
    public static function initialize(Application $app)
    {
        $app->group('/api', function () use ($app) {
            $app->group('/user', function () use ($app) {
                $app->post('/register', ['USaq\Controller\AuthenticationController', 'register']);
                $app->post('/login', ['USaq\Controller\AuthenticationController', 'login']);
                $app->post('/logout', ['USaq\Controller\AuthenticationController', 'logout']);
            });
        });
    }
}
