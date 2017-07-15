<?php

namespace USaq\Services\UserServices\Exception;

use USaq\App\Exception\ErrorInformation;
use USaq\App\Exception\USaqApplicationException;

class PermissionDeniedException extends USaqApplicationException
{
    protected $code = 403;

    /**
     * @inheritDoc
     */
    public function getTitle(): string
    {
        return 'Permission denied';
    }

    /**
     * @inheritDoc
     */
    public function getErrorInformation(): array
    {
        return ErrorInformation::USER_PERMISSION_ERROR;
    }
}