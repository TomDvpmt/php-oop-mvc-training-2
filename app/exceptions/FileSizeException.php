<?php

namespace PhpTraining2\exceptions;

use RuntimeException;

class FileSizeException extends RuntimeException {
    public $message = "File size too large.";

    public function __construct(private int $maxSize)
    {
        $megaBytes = number_format((float) $maxSize / 1000000, 2, ".", ",");
        $this->message = "File size must not exceed $megaBytes MB.";
    }
}