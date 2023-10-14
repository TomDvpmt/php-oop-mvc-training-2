<?php

namespace PhpTraining2\exceptions;

use RuntimeException;

class ProductGetDataException extends RuntimeException {
    public $message = "Unable to get product data.";

    public function __construct(private string $productDataType)
    {
        $productDataType = ucfirst($productDataType);
        $this->message = "$productDataType product could not be created.";
    }
}