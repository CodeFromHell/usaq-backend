<?php

namespace USaq\Service\Validation\Exception;

use USaq\App\Exception\USaqApplicationException;

class FieldValidationException extends USaqApplicationException
{
    /**
     * @inheritDoc
     */
    public function getTitle(): string
    {
        return 'Validation error';
    }

    /**
     * Add field validation error.
     *
     * @param string $field
     * @param string $error
     */
    public function addFieldError(string $field, string $error)
    {
        $this->extensions['fields'][$field] = $error;
    }

    /**
     * Add fields errors.
     *
     * @param array $errors
     */
    public function addFieldsErrors(array $errors)
    {
        $this->extensions['fields'] = $errors;
    }
}
