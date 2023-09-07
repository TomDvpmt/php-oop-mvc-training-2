<?php

namespace PhpTraining2\models;
require_once "Product.php";

final class Equipment extends Product {
    
    public function __construct(
        protected string $name, 
        protected string $description, 
        protected int $price, 
        protected string $imgUrl, 
        protected string $activity = "",
        )
    {
        parent::__construct($name, $description, $price, $imgUrl);
        $this->table = "equipments";
    }
}