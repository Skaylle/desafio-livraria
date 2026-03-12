<?php

namespace App\Exceptions;

use Exception;

class RequestValidationException extends Exception
{
    protected $errors;
    protected $statusCode;

    public function __construct($message, $errors, $statusCode)
    {
        parent::__construct($message);
        $this->errors = $errors;
        $this->statusCode = $statusCode;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }
}
