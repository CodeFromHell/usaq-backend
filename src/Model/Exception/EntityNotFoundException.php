<?php

namespace USaq\Model\Exception;

use USaq\App\Exception\ErrorInformation;
use USaq\App\Exception\USaqApplicationException;

/**
 * Thrown when entity is not found.
 */
class EntityNotFoundException extends USaqApplicationException
{
    /**
     * @inheritdoc
     */
    public function getTitle(): string
    {
        return 'Entity not found';
    }

    /**
     * @inheritdoc
     */
    public function getErrorInformation(): array
    {
        return ErrorInformation::ENTITY_NOT_FOUND;
    }
}
