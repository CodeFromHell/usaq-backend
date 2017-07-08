<?php

namespace USaq\Routes;

use USaq\App\Application;

interface RoutesProviderInterface
{
    /**
     * Register new routes.
     *
     * @param Application $app
     * @return mixed
     */
    public function registerRoutes(Application $app);
}
