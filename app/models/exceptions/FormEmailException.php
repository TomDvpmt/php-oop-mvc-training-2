<?php

namespace PhpTraining2\models\exceptions;

use RuntimeException;

class FormEmailException extends RuntimeException {
    public $message = "Wrong email format.";
}