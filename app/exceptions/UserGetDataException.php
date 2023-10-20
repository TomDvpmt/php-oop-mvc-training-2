<?php

namespace PhpTraining2\exceptions;

use RuntimeException;

class UserGetDataException extends RuntimeException {
    public $message = "Unable to get user data.";
}