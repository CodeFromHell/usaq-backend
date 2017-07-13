<?php

namespace USaq\Services\Validation\Exception;

use USaq\App\Exception\USaqApplicationException;

class PasswordNotMatchException extends USaqApplicationException
{
    public function getTitle(): string
    {
        return 'Passwords not match';
    }
}
