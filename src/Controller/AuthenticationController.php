<?php

namespace USaq\Controller;

use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use USaq\Model\Entity\User;

class AuthenticationController
{
    private $logger;

    private $entity;

    public function __construct(LoggerInterface $logger, EntityManager $entity)
    {
        $this->logger = $logger;
        $this->entity = $entity;
    }

    public function login(Request $request, Response $response)
    {
        $this->logger->info('Entrar en login');

        $user = new User();
        $user->setMail("msmmam@msmsm.com");
        $user->setNickname("asdsada");

        $this->entity->persist($user);

        $this->entity->flush();

        return $response->getBody()->write('Texto');
    }
}
