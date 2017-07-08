<?php
/**
 * Created by IntelliJ IDEA.
 * User: RJ Corchero
 * Date: 05/07/2017
 * Time: 21:37
 */

namespace USaq\Routes;

use USaq\App\Application;

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
            $app->map(['POST', ], '/logout', ['USaq\Controller\AuthenticationController', 'logout']);
        });
    }
}
