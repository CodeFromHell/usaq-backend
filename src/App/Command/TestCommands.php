<?php

namespace USaq\App\Command;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\DropCommand;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\SchemaTool;
use Robo\Robo;
use Robo\Tasks;
use USaq\Service\Validation\ValidationService;

class TestCommands extends Tasks
{
    /**
     * @var ValidationService
     */
    private $validationService;

    public function __construct()
    {
        $this->setValidationService(Robo::getContainer()->get(ValidationService::class));
    }

    public function setValidationService(ValidationService $service)
    {
        $this->validationService = $service;
    }

    /**
     * @param string $name      Provide a name
     * @param array $options
     * @option $yell            Yell the name!
     */
    public function test($name, $options = ['yell|y' => false])
    {
        $this->io()->title('Testing application');

        $message = 'Hello, ' . $name;

        if ($options['yell'])
            $message = strtoupper($message);

        $this->io()->text($message);
    }

    public function load($entityName)
    {
        /** @var EntityManager $em */
        $em = Robo::getContainer()->get('persistence');

        $helper = ConsoleRunner::createHelperSet($em);

        $command = new \Doctrine\ORM\Tools\Console\Command\MappingDescribeCommand();
        $command->setHelperSet($helper);
        $this->taskSymfonyCommand($command)->arg('entityName', $entityName)->run();
    }
}