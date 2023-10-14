<?php

namespace PhpTraining2\exceptions;

use RuntimeException;

class FormEmailException extends RuntimeException {
    public $message = "Wrong email format.";
}