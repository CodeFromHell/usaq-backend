<?php

namespace USaq\Services\Validation\Exception;

use USaq\App\Exception\ErrorInformation;
use USaq\App\Exception\USaqApplicationException;

/**
 * Thrown when provide password not match with correct one.
 */
class PasswordNotMatchException extends USaqApplicationException
{
    /**
     * @inheritdoc
     */
    public function getTitle(): string
    {
        return 'Passwords not match';
    }

    /**
     * @inheritdoc
     */
    public function getErrorInformation(): array
    {
        return ErrorInformation::VALIDATION_PASS_NOT_MATCH_ERROR;
    }
}
