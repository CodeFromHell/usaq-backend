<?php

namespace USaq\App\Exception;

/**
 * Class USaqApplicationException.
 *
 * Base class for exceptions. Each implementation should add own information about error to extension property.
 */
abstract class USaqApplicationException extends \Exception
{
    protected $extensions = [];

    /**
     * Return exception title. Must be short and simple.
     *
     * @return string
     */
    abstract public function getTitle(): string;

    /**
     * Return extension data.
     *
     * @return array
     */
    public final function getExtensionData(): array
    {
        return $this->extensions;
    }
}