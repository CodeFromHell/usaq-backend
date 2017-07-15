<?php

namespace USaq\Templating\Exception;

use USaq\App\Exception\ErrorInformation;
use USaq\App\Exception\USaqApplicationException;

class TemplateEngineException extends USaqApplicationException
{
    /**
     * @inheritdoc
     */
    public function getTitle(): string
    {
        return 'Template engine error';
    }

    /**
     * @inheritdoc
     */
    public function getErrorInformation(): array
    {
        return ErrorInformation::TEMPLATE_ERROR;
    }
}
