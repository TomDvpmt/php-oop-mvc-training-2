<?php

namespace PhpTraining2\models\exceptions;

use RuntimeException;

class FormEmptyFieldException extends RuntimeException {
    public $message = "All required fields must be filled.";
}