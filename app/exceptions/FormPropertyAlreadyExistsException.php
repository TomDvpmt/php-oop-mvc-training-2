<?php

namespace PhpTraining2\exceptions;

use RuntimeException;

class FormPropertyAlreadyExistsException extends RuntimeException {
    public $message;

    public function __construct(string $property)
    {
        $this->message = "This $property already exists, please choose another one.";
    }
}