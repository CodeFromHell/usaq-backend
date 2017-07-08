<?php

namespace USaq\App\Console\Commands;

use Robo\Tasks;

class DevelopmentCommands extends Tasks
{
    public function devServe()
    {
        $this->taskServer()->dir('public')->background()->run();
    }

    public function devFix($directory = 'src/Middleware')
    {
        $this->taskExec('php-cs-fixer fix')->arg($directory)->run();
    }

    public function devTest()
    {
        $this->taskCodecept()->run();
    }
}
