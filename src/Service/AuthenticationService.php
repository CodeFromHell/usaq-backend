<?php

namespace USaq\Service;

use Doctrine\ORM\EntityManager;
use USaq\Model\Entity\Token;
use USaq\Model\Entity\User;
use USaq\Model\Exception\EntityNotFoundException;
use USaq\Service\Exception\AuthenticationException;

/**
 * Provide operations to authenticate an user.
 *
 * @package USaq\Service
 */
class AuthenticationService
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * AuthenticationService constructor.
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function createUser($username, $password)
    {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        $user = new User($username, $passwordHash);

        $this->em->persist($user);

        $this->em->flush();
    }

    public function loginUser($username, $password): Token
    {
        $userRepository = $this->em->getRepository('USaq\Model\Entity\User');

        /** @var User $user */
        $user = $userRepository->findOneBy(['username' => $username]);

        if (!$user || !password_verify($password, $user->getPassword()))
            throw new AuthenticationException('Incorrect username or password');

        $token = new Token();
        $token->setUser($user);
        $token->setExpireAt(new \DateTime('now + 15 days'));
        $token->generateRandomToken();

        $this->em->persist($token);
        $this->em->flush();

        return $token;
    }

    public function retrieveUserByToken(string $tokenString): User
    {
        $tokenRepository = $this->em->getRepository('USaq\Model\Entity\Token');

        /** @var Token $token */
        $token = $tokenRepository->findOneBy(['tokenString' => $tokenString]);

        if (!$token)
            throw new EntityNotFoundException('Token not found');

        return $token->getUser();
    }
}