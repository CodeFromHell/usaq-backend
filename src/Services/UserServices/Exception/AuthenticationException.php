<?php

namespace USaq\Services\UserServices\Exception;

use USaq\App\Exception\ErrorInformation;
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

    /**
     * @inheritdoc
     */
    public function getErrorInformation(): array
    {
        return ErrorInformation::USER_AUTHENTICATION_ERROR;
    }
}
