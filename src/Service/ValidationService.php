<?php

namespace USaq\Service;

use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as V;

class ValidationService
{
    private $usernameValidator;

    private $passwordValidator;

    public function __construct()
    {
        $this->usernameValidator = V::alnum()->length(4, 30);
        $this->passwordValidator = V::alnum()->length(4, 30);
    }

    public function validateRegisterRequest($data)
    {
        $errors = '';

        try {
            V::keySet(
                V::key('user', $this->usernameValidator),
                V::key('password', $this->passwordValidator),
                V::key('password_repeat', $this->passwordValidator)
            )
            ->keyValue('password_repeat', 'equals', 'password')
            ->assert($data);
        } catch (NestedValidationException $e) {
            $errors = $e->getFullMessage();
        }

        return $errors;
    }
}