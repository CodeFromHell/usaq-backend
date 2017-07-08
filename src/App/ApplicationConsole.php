<?php

namespace USaq\App;

use Psr\Container\ContainerInterface;
use Robo\Application;
use Robo\Common\ConfigAwareTrait;
use Robo\Config\Config;
use Robo\Robo;
use Robo\Runner;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use USaq\App\Command\DevelopmentCommands;
use USaq\App\Command\TestCommands;
use USaq\Service\Validation\ValidationService;

class ApplicationConsole
{
    use ConfigAwareTrait;

    private $runner;

    private $commands = [
        TestCommands::class,
        DevelopmentCommands::class
    ];

    public function __construct(
        Config $config,
        InputInterface $input = NULL,
        OutputInterface $output = NULL,
        ContainerInterface $applicationContainer
    ) {
        // Create applicaton.
        $this->setConfig($config);
        $application = new Application('My Application', $config->get('version'));

        // Create and configure container.
        $container = Robo::createDefaultContainer($input, $output, $application, $config);
        $container->delegate($applicationContainer);

        // Instantiate Robo Runner.
        $this->runner = new Runner();

        $this->runner->setContainer($container);
    }

    public function run(InputInterface $input, OutputInterface $output) {
        $status_code = $this->runner->run($input, $output, null, $this->commands);
        return $status_code;
    }
}