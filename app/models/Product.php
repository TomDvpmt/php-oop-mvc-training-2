<?php

namespace PhpTraining2\models;

use PhpTraining2\core\Model;

class Product {
    use Model;

    public function __construct(private string $name, private string $description, private int $price)
    {}

    public function createProduct() {
        show("product added");
    }
}