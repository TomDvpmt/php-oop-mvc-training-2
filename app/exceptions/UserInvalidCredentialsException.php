<?php

namespace PhpTraining2\exceptions;

use RuntimeException;

class UserInvalidCredentialsException extends RuntimeException {
    public $message = "Invalid email address or password.";
}