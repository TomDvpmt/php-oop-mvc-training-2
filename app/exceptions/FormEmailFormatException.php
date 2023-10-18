<?php

namespace PhpTraining2\exceptions;

use RuntimeException;

class FormEmailFormatException extends RuntimeException {
    public $message = "Wrong email format.";
}