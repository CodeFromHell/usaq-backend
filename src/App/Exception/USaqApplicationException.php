<?php

namespace USaq\App\Exception;

/**
 * Class USaqApplicationException.
 *
 * Base class for exceptions. Each implementation should add own information about errors
 * to {@see USaqApplicationException::extensions} property.
 */
abstract class USaqApplicationException extends \Exception
{
    protected $code = 400;

    /**
     * Extension to be added for each exception.
     *
     * @var array
     */
    protected $extensions = [];

    /**
     * Return exception title. Must be short and simple.
     *
     * @return string
     */
    abstract public function getTitle(): string;

    /**
     * Returns error information.
     *
     * @return array
     *
     * @see ErrorInformation
     */
    abstract public function getErrorInformation(): array;

    /**
     * Return extension data.
     *
     * @return array
     */
    final public function getExtensionData(): array
    {
        return $this->extensions;
    }
}
