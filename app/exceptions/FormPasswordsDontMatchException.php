<?php

namespace PhpTraining2\exceptions;

use RuntimeException;

class FormPasswordsDontMatchException extends RuntimeException 
{
    public function __construct()
    {
        $this->message = "Passwords don't match.";
    }
}