<?php

namespace PhpTraining2\models;
require_once "Product.php";

final class Shoe extends Product {

    public function __construct(
        protected string $name = "", 
        protected string $description = "", 
        protected int $price = 0, 
        protected string $imgUrl = "", 
        protected int $waterproof = 1, 
        protected int $level = 1)
    {
        parent::__construct($name, $description, $price, $imgUrl);
    }

    /**
     * Add a shoe
     * 
     * @access public
     * @package PhpTraining2\controllers
     */

     public function createShoe() {
        $data = [
            "name" => $this->name,
            "description" => $this->description,
            "price" => $this->price,
            "waterproof" => $this->waterproof,
            "level" => $this->level,
            "img_url" => $this->imgUrl,
        ];
        $this->create($data);
    }
}