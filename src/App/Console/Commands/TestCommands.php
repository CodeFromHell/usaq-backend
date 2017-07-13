<?php

namespace USaq\App\Console\Commands;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\Command\MappingDescribeCommand;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Robo\Robo;
use Robo\Tasks;
use USaq\Services\Validation\Exception\FieldValidationException;
use USaq\Services\Validation\ValidationService;

/**
 * Test commands.
 */
class TestCommands extends Tasks
{
    /**
     * @var ValidationService
     */
    private $validationService;

    /**
     * TestCommands constructor.
     *
     * @param ValidationService $service
     */
    public function __construct(ValidationService $service)
    {
        $this->validationService = $service;
    }

    /**
     * Testing console.
     *
     * @param string $name      Provide a name.
     * @param array $options
     * @option $yell            Yell the name!
     */
    public function testSay($name, $options = ['yell|y' => false])
    {
        $this->io()->title('Testing application');

        $a = new \stdClass();
        $a->id =1;

        $b = new \stdClass();
        $b->id = 2;

        $arr = [$a, $b];

        $arr1 = array_map(function($element) {
            return $element->id;
        }, $arr);

        $this->io()->write(print_r($arr1, true));

        try {
            $this->validationService->validateLoginRequest(['asdad' => 'asddas']);
            $this->io()->text('Ok');
        } catch (FieldValidationException $e) {
            $this->io()->text($e->getMessage());
        }

        $message = 'Hello, ' . $name;

        if ($options['yell']) {
            $message = strtoupper($message);
        }

        $this->io()->text($message);
    }

    /**
     * Describe mapping of entity.
     *
     * @param string $entityName    Entity name.
     */
    public function testDescribe($entityName)
    {
        /** @var EntityManager $em */
        $em = Robo::getContainer()->get('persistence');

        $helper = ConsoleRunner::createHelperSet($em);

        $command = new MappingDescribeCommand();
        $command->setHelperSet($helper);
        $this->taskSymfonyCommand($command)->arg('entityName', $entityName)->run();
    }
}
