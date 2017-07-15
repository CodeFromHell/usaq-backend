<?php

namespace USaq\App\Exception;

class ErrorInformation
{
    /**
     * All error codes as array.
     */
    const ERROR_CODES = [
        /**
         * Unefined errors
         */
        self::UNDEFINED_ERROR['error_code'] => self::UNDEFINED_ERROR,

        /**
         * Error from entities and repositories
         */
        self::ENTITY_ALREADY_EXISTS['error_code'] => self::ENTITY_ALREADY_EXISTS,
        self::ENTITY_NOT_FOUND['error_code'] => self::ENTITY_NOT_FOUND,

        /**
         * Validation errors from Service > Validation
         */
        self::VALIDATION_FIELD_ERROR['error_code'] => self::VALIDATION_FIELD_ERROR,
        self::VALIDATION_PASS_NOT_MATCH_ERROR['error_code'] => self::VALIDATION_PASS_NOT_MATCH_ERROR,

        /**
         * Errors from user service Service > USerServices
         */
        self::USER_AUTHENTICATION_ERROR['error_code'] => self::USER_AUTHENTICATION_ERROR,
        self::USER_UNAUTHORIZED_ERROR['error_code'] => self::USER_UNAUTHORIZED_ERROR,

        /**
         * Template engine errors from Templating
         */
        self::TEMPLATE_ERROR['error_code'] => self::TEMPLATE_ERROR
    ];

    // Error definition
    const UNDEFINED_ERROR = ['error_code' => 0, 'description' => 'Undefined error'];

    const ENTITY_ALREADY_EXISTS = ['error_code' => 1, 'description' => 'Trying to persist entity that already exists'];
    const ENTITY_NOT_FOUND = ['error_code' => 2, 'description' => 'Entity not found'];

    const VALIDATION_FIELD_ERROR = ['error_code' => 11, 'description' => 'Fields validation error'];
    const VALIDATION_PASS_NOT_MATCH_ERROR = ['error_code' => 12, 'description' => 'Passwords not match'];

    const USER_AUTHENTICATION_ERROR = ['error_code' => 110, 'description' => 'Error authentication user'];
    const USER_UNAUTHORIZED_ERROR = ['error_code' => 111, 'description' => 'User is no authorized to see this resource'];

    const TEMPLATE_ERROR = ['error_code' => 300, 'description' => 'Error renderizing data'];
}
