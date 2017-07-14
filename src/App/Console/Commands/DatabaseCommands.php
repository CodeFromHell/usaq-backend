<?php

namespace USaq\App\Console\Commands;

use Doctrine\DBAL\Migrations\Tools\Console\Command\DiffCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\MigrateCommand;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Robo\Robo;
use Robo\Tasks;
use Symfony\Component\Console\Helper\QuestionHelper;
use USaq\App\Console\Commands\Tasks\loadTasks;

class DatabaseCommands extends Tasks
{
    use loadTasks;

    /**
     * Generate migration from diff and run it.
     */
    public function databaseDiffMigrate()
    {
        /** @var EntityManager $em */
        $em = Robo::getContainer()->get('persistence');

        $helperSet = ConsoleRunner::createHelperSet($em);
        $helperSet->set(new QuestionHelper(), 'question');

        $diffCommand = new DiffCommand();
        $diffCommand->setHelperSet($helperSet);

        $migrateCommand = new MigrateCommand();
        $migrateCommand->setHelperSet($helperSet);

        $builder = $this->collectionBuilder();
        $builder->addTaskList([
            $this->taskSymfony($diffCommand)->noInteractive(),
            $this->taskSymfony($migrateCommand)->noInteractive()
        ])->run();
    }

    /**
     * Run migrations.
     *
     * @param string $version   The version number (YYYYMMDDHHMMSS) or alias (first, prev, next, latest) to migrate to. [default: "latest"]
     */
    public function databaseMigrate($version = 'latest')
    {
        /** @var EntityManager $em */
        $em = Robo::getContainer()->get('persistence');

        $helperSet = ConsoleRunner::createHelperSet($em);
        $helperSet->set(new QuestionHelper(), 'question');

        $command = new MigrateCommand();
        $command->setHelperSet($helperSet);

        $this->taskSymfony($command)->arg('version', $version)->noInteractive()->run();
    }
}
