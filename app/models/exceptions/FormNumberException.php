<?php

namespace PhpTraining2\models\exceptions;

use RuntimeException;

class FormNumberException extends RuntimeException {
    public $message = "Wrong number format.";
}