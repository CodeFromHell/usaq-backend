<?php

namespace USaq\Model\Exception;

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
}
