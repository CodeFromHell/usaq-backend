<?php

namespace USaq\Service\Exception;


use USaq\App\Exception\USaqApplicationException;

class AuthenticationException extends USaqApplicationException
{
    /**
     * @inheritDoc
     */
    public function getTitle(): string
    {
        return 'Authentication incorrect';
    }
}