<?php

namespace USaq\Services\UserServices;

use Doctrine\ORM\EntityManager;
use USaq\Model\Entity\Token;
use USaq\Model\Entity\User;
use USaq\Model\Exception\AlreadyExistsException;
use USaq\Model\Exception\EntityNotFoundException;
use USaq\Services\UserServices\Exception\AuthenticationException;

/**
 * Provide an implementation for database.
 *
 * @package USaq\Services
 */
class AuthenticationServiceDb implements AuthenticationService
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * AuthenticationServiceDb constructor.
     *
     * @param EntityManager $em
     * @param UserService $userService
     */
    public function __construct(EntityManager $em, UserService $userService)
    {
        $this->em = $em;
        $this->userService = $userService;
    }

    /**
     * @inheritdoc
     */
    public function registerUser(array $userData): void
    {
        if ($this->userService->checkIfUsernameExists($userData['username'])) {
            throw new AlreadyExistsException(sprintf('There is already an User with the username %s', $userData['username']));
        }

        $passwordHash = password_hash($userData['password'], PASSWORD_BCRYPT);

        $user = new User($userData['username'], $passwordHash);

        $this->em->persist($user);

        $this->em->flush();
    }

    /**
     * @inheritdoc
     */
    public function loginUser(array $userCredentials): Token
    {
        $userRepository = $this->em->getRepository(User::class);

        /** @var User $user */
        $user = $userRepository->findOneBy(['username' => $userCredentials['username']]);

        if (!$user || !password_verify($userCredentials['password'], $user->getPassword())) {
            throw new AuthenticationException('Incorrect username or password');
        }

        $token = new Token();
        $token->setUser($user);
        $token->setExpireAt(new \DateTime('now + 15 days'));
        $token->generateRandomToken();

        $this->em->persist($token);
        $this->em->flush();

        return $token;
    }

    /**
     * Get user via token.
     *
     * @param string $tokenString       Token string.
     * @return User                     User identified by token string.
     * @throws EntityNotFoundException  If no user is found by this token.
     */
    public function retrieveUserByToken(string $tokenString): User
    {
        $tokenRepository = $this->em->getRepository(Token::class);

        /** @var Token $token */
        $token = $tokenRepository->findOneBy(['tokenString' => $tokenString]);

        if (!$token) {
            throw new EntityNotFoundException('Token not found');
        }

        // Each time a token is retrieved update expiration date
        $token->setExpireAt(new \DateTime('now + 15 days'));

        return $token->getUser();
    }

    /**
     * @inheritdoc
     */
    public function logoutUser(string $tokenString): void
    {
        /** @var Token $token */
        $token = $this->em->getRepository(Token::class)->findOneBy(['tokenString' => $tokenString]);

        if (!$token) {
            throw new EntityNotFoundException('Token not found');
        }

        // Each time a token is retrieved update expiration date
        $this->em->remove($token);
        $this->em->flush();
    }
}
