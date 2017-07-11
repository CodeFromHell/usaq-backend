<?php

namespace USaq\Templating\Exception;

use USaq\App\Exception\USaqApplicationException;

class TemplateEngineException extends USaqApplicationException
{
    /**
     * @inheritDoc
     */
    public function getTitle(): string
    {
        return 'Template engine error';
    }
}
