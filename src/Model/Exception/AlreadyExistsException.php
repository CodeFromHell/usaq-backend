<?php

namespace USaq\Model\Exception;

use USaq\App\Exception\USaqApplicationException;

class AlreadyExistsException extends USaqApplicationException
{
    /**
     * @inheritDoc
     */
    public function getTitle(): string
    {
        return 'Entity already exists';
    }
}
