<?php

namespace USaq\Routes\Api;

use USaq\App\Application;
use USaq\Routes\RoutesProviderInterface;

class UtilsRoutes implements RoutesProviderInterface
{
    /**
     * @inheritDoc
     */
    public function registerRoutes(Application $app): void
    {
        $app->get('/error[/{identifier:[0-9]+}]', ['USaq\Controller\UtilsController', 'showErrors']);
    }
}
