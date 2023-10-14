<?php

namespace PhpTraining2\exceptions;

use RuntimeException;

class FileTypeException extends RuntimeException {
    public $message = "Incorrect file format.";

    public function __construct(private array $allowedExtensions)
    {
        $extensionsString = implode(", ", $allowedExtensions);
        $this->message = "Incorrect file format. Allowed formats: $extensionsString.";
    }
}