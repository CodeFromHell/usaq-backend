<?php
/**
 * Configuration for doctrine cli.
 */

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use USaq\StaticProxy\Container;

// replace with file to your own project bootstrap
require __DIR__ . '/bootstrap.php';

// replace with mechanism to retrieve EntityManager in your app
$entityManager = Container::get('persistence');

$helperSet = ConsoleRunner::createHelperSet($entityManager);
$helperSet->set(new \Symfony\Component\Console\Helper\QuestionHelper(), 'question');

// Add Doctrine Migration commands
$cli = ConsoleRunner::createApplication($helperSet,[
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\DiffCommand(),
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\ExecuteCommand(),
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\GenerateCommand(),
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\MigrateCommand(),
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\StatusCommand(),
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\VersionCommand(),
]);

return $cli->run();