<?php

namespace USaq\Model\Exception;

use USaq\App\Exception\ErrorInformation;
use USaq\App\Exception\USaqApplicationException;

/**
 * Thrown when entity already exists.
 */
class AlreadyExistsException extends USaqApplicationException
{
    /**
     * @inheritdoc
     */
    public function getTitle(): string
    {
        return 'Entity already exists';
    }

    /**
     * @inheritdoc
     */
    public function getErrorInformation(): array
    {
        return ErrorInformation::ENTITY_ALREADY_EXISTS;
    }
}
