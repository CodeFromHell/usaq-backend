<?php

namespace USaq\App\Command;

use Robo\Tasks;

class DevelopmentCommands extends Tasks
{
    public function devServe()
    {
        $this->taskServer()->dir('public')->background()->run();
    }

    public function devFix()
    {
        $this->_exec('php-cs-fixer fix src/Middleware');
    }

    public function devTest()
    {
        $this->taskCodecept()->run();
    }
}