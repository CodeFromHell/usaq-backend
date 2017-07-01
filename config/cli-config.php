<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

// replace with file to your own project bootstrap
$app = \USaq\App\Application::bootstrap();

// replace with mechanism to retrieve EntityManager in your app
$entityManager = $app->getContainer()->get('persistence');

return ConsoleRunner::createHelperSet($entityManager);