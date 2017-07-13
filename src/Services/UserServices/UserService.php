<?php

namespace USaq\Services\UserServices;

use Doctrine\Common\Collections\Collection;
use USaq\Model\Entity\User;

/**
 * Interface UserService provides operations to store and retrieve Users.
 */
interface UserService
{
    /**
     * Create new User or update existing User.
     *
     * @param User $user
     * @param bool $sync    Should data be synchronized with persistence layer?
     * @return User         Created User.
     */
    public function store(User $user, bool $sync = true): User;

    /**
     * Delete User.
     *
     * @param User $user
     * @param bool $sync    Should data be synchronized with persistence layer?
     */
    public function delete(User $user, bool $sync = true): void;

    /**
     * Check if there is already an User with username.
     *
     * @param string $username
     * @return bool
     */
    public function checkIfUsernameExists(string $username): bool;

    /**
     * Get all users.
     *
     * @return User[]
     */
    public function getAll(): array;

    /**
     * Get all users except authenticated.
     *
     * @param User[] |int[] $users     List of users (or users's ids) that don't have to appear in the list.
     * @return User[]
     */
    public function getAllExcept(array $users): array;
}