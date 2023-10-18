<?php

namespace PhpTraining2\exceptions;

use RuntimeException;

class UserCreateException extends RuntimeException {
    public $message = "Unable to create user.";
}