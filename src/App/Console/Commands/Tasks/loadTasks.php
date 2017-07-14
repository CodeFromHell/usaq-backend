<?php

namespace USaq\App\Console\Commands\Tasks;

use Symfony\Component\Console\Command\Command;

trait loadTasks
{
    /**
     * @param Command $command
     * @return SymfonyTask
     */
    protected function taskSymfony($command)
    {
        return $this->task(SymfonyTask::class, $command);
    }
}
