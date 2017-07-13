<?php

namespace USaq\Services\UserServices;

use USaq\Model\Entity\Token;
use USaq\Model\Entity\User;
use USaq\Model\Exception\AlreadyExistsException;
use USaq\Model\Exception\EntityNotFoundException;
use USaq\Services\UserServices\Exception\AuthenticationException;

/**
 * Interface AuthenticationService provides operations to register and authenticate an User in the application.
 */
interface AuthenticationService
{
    /**
     * Check that user not exist and register new user in application.
     *
     * @param array $credentials        Array with username and password.
     * @throws AlreadyExistsException   If there is already an user with the same username.
     */
    public function registerUser(array $credentials): void;

    /**
     * Checks if user exists and if credentials are correct, create identifier Token and return it.
     *
     * @param array $userCredentials    Array with user credentials username and password.
     * @return Token                    Token resource.
     * @throws AuthenticationException  If user cannot be authenticated.
     */
    public function loginUser(array $userCredentials): Token;

    /**
     * Delete user token that mark it as authenticated in the system.
     *
     * @param string $tokenString       Identifier token of user to be deleted.
     * @throws EntityNotFoundException  If there is no Token that match.
     */
    public function logoutUser(string $tokenString): void;

    /**
     * Get user via token.
     *
     * @param string $tokenString       Token string.
     * @return User                     User identified by token string.
     * @throws EntityNotFoundException  If no user is found by this token.
     */
    public function retrieveUserByToken(string $tokenString): User;
}