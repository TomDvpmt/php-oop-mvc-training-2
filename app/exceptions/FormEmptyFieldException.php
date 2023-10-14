<?php

namespace PhpTraining2\exceptions;

use RuntimeException;

class FormEmptyFieldException extends RuntimeException {
    public $message = "All required fields must be filled.";
}