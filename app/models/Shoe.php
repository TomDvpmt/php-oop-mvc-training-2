<?php

namespace PhpTraining2\models;
require_once "Product.php";

class Shoe extends Product {

    public function __construct(protected int $waterproof = 1, protected int $level = 1)
    {
        parent::__construct();
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