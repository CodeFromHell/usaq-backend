<?php

namespace USaq\App;

use Consolidation\AnnotatedCommand\CommandFileDiscovery;
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
        InputInterface $input = null,
        OutputInterface $output = null,
        ContainerInterface $applicationContainer
    ) {
        // Create applicaton.
        $this->setConfig($config);
        $application = new Application('My Application', $config->get('version'));

        // Create and configure container.
        $container = Robo::createDefaultContainer($input, $output, $application, $config);
        // Add container application using delegate lookup
        $container->delegate($applicationContainer);

        // Instantiate Robo Runner.
        $this->runner = new Runner();
        $this->runner->setContainer($container);

        // Add commands
        $discovery = new CommandFileDiscovery();
        $discovery->setSearchPattern('/.*Command(s){0,1}.php/');
        $this->commands = $discovery->discover('src/App/Command', '\USaq\App\Command');
    }

    public function run(InputInterface $input, OutputInterface $output)
    {
        $status_code = $this->runner->run($input, $output, null, $this->commands);
        return $status_code;
    }
}
