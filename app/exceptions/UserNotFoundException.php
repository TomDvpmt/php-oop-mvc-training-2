<?php

namespace PhpTraining2\exceptions;

use RuntimeException;

class UserNotFoundException extends RuntimeException {
    public $message = "Unable to get user data.";
}