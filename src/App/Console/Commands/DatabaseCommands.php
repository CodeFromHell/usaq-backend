<?php

namespace USaq\App\Console\Commands;

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
     * Run migrations.
     */
    public function migrationsMigrate()
    {
        /** @var EntityManager $em */
        $em = Robo::getContainer()->get('persistence');

        $helperSet = ConsoleRunner::createHelperSet($em);
        $helperSet->set(new QuestionHelper(), 'dialog');

        $command = new \Doctrine\DBAL\Migrations\Tools\Console\Command\MigrateCommand();
        $command->setHelperSet($helperSet);

        $this->taskSymfony($command)->noInteractive()->run();
    }
}
