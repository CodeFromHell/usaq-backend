<?php

namespace USaq\Services\UserServices\Exception;

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
}
