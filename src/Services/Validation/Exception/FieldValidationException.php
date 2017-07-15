<?php

namespace USaq\Services\Validation\Exception;

use USaq\App\Exception\ErrorInformation;
use USaq\App\Exception\USaqApplicationException;

/**
 * Thrown when there an error in a field validation.
 */
class FieldValidationException extends USaqApplicationException
{
    /**
     * @inheritdoc
     */
    public function getTitle(): string
    {
        return 'Validation error';
    }

    /**
     * @inheritdoc
     */
    public function getErrorInformation(): array
    {
        return ErrorInformation::VALIDATION_FIELD_ERROR;
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
