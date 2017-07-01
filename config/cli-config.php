<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

// replace with file to your own project bootstrap
$app = require __DIR__ . '/../src/App/ApplicationBootstrap.php';

// replace with mechanism to retrieve EntityManager in your app
$entityManager = $app->getContainer()->get('persistence');

return ConsoleRunner::createHelperSet($entityManager);