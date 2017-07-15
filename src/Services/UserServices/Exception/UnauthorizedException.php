<?php

namespace USaq\Services\UserServices\Exception;

use USaq\App\Exception\ErrorInformation;
use USaq\App\Exception\USaqApplicationException;

class UnauthorizedException extends USaqApplicationException
{
    protected $code = 401;

    /**
     * @inheritDoc
     */
    public function getTitle(): string
    {
        return 'Unauthorized';
    }

    /**
     * @inheritDoc
     */
    public function getErrorInformation(): array
    {
        return ErrorInformation::USER_UNAUTHORIZED_ERROR;
    }
}
