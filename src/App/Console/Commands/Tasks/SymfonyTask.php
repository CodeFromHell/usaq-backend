<?php

namespace USaq\App\Console\Commands\Tasks;

use Robo\Result;
use Robo\Robo;
use Robo\Task\Base\SymfonyCommand;
use Symfony\Component\Console\Input\ArrayInput;

/**
 * COverride SymfonyCommnand task from Robo package.
 *
 * Provide no interactive run of commands.
 */
class SymfonyTask extends SymfonyCommand
{
    /**
     * Interactive?
     *
     * @var bool
     */
    protected $interactive = true;

    /**
     * Make command no interactive.
     *
     * @return $this
     */
    public function noInteractive()
    {
        $this->interactive = false;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function run()
    {
        $this->printTaskInfo('Running command {command}', ['command' => $this->command->getName()]);

        $input = new ArrayInput($this->input);
        $input->setInteractive($this->interactive);

        return new Result(
            $this,
            $this->command->run($input, Robo::output())
        );
    }
}
