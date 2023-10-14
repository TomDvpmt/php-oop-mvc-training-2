<?php

namespace PhpTraining2\exceptions;

use RuntimeException;

class FormNumberException extends RuntimeException {
    public $message = "Wrong number format.";
}