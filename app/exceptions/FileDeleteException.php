<?php 

namespace PhpTraining2\exceptions;

use RuntimeException;

class FileDeleteException extends RuntimeException {
    public $message = "Unable to delete file.";
}