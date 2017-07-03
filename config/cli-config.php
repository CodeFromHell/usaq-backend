<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

// replace with file to your own project bootstrap
/**
 * @var \Psr\Container\ContainerInterface $container
 */
$container = require __DIR__ . '/../src/App/ContainerBootstrap.php';

// replace with mechanism to retrieve EntityManager in your app
$entityManager = $container->get('persistence');

return ConsoleRunner::createHelperSet($entityManager);