<?php

namespace USaq\Model\Exception;

use USaq\App\Exception\USaqApplicationException;

class EntityNotFoundException extends USaqApplicationException
{
    /**
     * @inheritDoc
     */
    public function getTitle(): string
    {
        return 'Entity not found';
    }
}
