<?php

namespace PhpTraining2\exceptions;

use RuntimeException;

class ProductCreateException extends RuntimeException {
    public $message = "Product could not be created.";

    public function __construct(private string $productType)
    {
        $productType = ucfirst($productType);
        $this->message = "$productType product could not be created.";
    }
}