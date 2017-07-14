<?php

namespace USaq\Services\UserServices;

use Doctrine\ORM\EntityManager;
use USaq\Model\Entity\User;
use USaq\Model\Repository\UserRepository;

/**
 * Provides an implementation for {@see UserService} oriented toward database persistence.
 */
class UserServiceDb implements UserService
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * AuthenticationServiceDb constructor.
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @inheritdoc
     */
    public function store(User $user, bool $sync = true): User
    {
        $this->em->persist($user);

        if ($sync) {
            $this->em->flush();
        }

        return $user;
    }

    /**
     * @inheritdoc
     */
    public function delete(User $user, bool $sync = true): void
    {
        $this->em->remove($user);

        if ($sync) {
            $this->em->flush();
        }
    }

    /**
     * @inheritdoc
     */
    public function checkIfUsernameExists(string $username): bool
    {
        $user = $this->em->getRepository(User::class)->findOneBy(['username' => $username]);

        return (bool) $user;
    }

    /**
     * @inheritdoc
     */
    public function getAll(): array
    {
        $users = $this->em->getRepository(User::class)->findAll();

        return $users;
    }

    /**
     * @inheritdoc
     */
    public function getAllExcept(array $users): array
    {
        $userIds = array_map(function ($user) {
            if ($user instanceof User) {
                return $user->getId();
            } else {
                return (int) $user;
            }
        }, $users);

        /** @var UserRepository $userRepository */
        $userRepository = $this->em->getRepository(User::class);

        return $userRepository->getAllExcept($userIds);
    }
}
