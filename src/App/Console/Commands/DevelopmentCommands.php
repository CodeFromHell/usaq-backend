<?php

namespace USaq\App\Console\Commands;

use Robo\Tasks;

class DevelopmentCommands extends Tasks
{
    public function developmentServe()
    {
        $this->taskServer()->dir('public')->background()->run();
    }

    public function developmentFix($directory = 'src')
    {
        $this->taskExec('php-cs-fixer fix')->arg($directory)->run();
    }

    public function developmentTest()
    {
        $this->taskCodecept()->run();
    }

    public function deploy()
    {
        $builder = $this->collectionBuilder();
        $builder->addTaskList([
                $this->taskCodecept(),
                $this->taskExec('dep')->dir('vendor/bin')->arg('deploy')->arg('production')
            ]
        )->run();
    }
}
