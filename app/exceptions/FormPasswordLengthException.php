<?php

namespace PhpTraining2\exceptions;

use RuntimeException;

class FormPasswordLengthException extends RuntimeException {
    public $message = "Wrong password length.";

    public function __construct(private int $minLength)
    {
        $this->message = "Password must be at least $minLength characters long.";
    }
}