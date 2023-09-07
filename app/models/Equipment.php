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
    }

    /**
     * Add an equipment item
     * 
     * @access public
     * @package PhpTraining2\controllers
     */

     public function createEquipment() {
        $data = [
            "name" => $this->name,
            "description" => $this->description,
            "price" => $this->price,
            "img_url" => $this->imgUrl,
            "activity" => $this->activity,
        ];
        $this->create($data);
    }
}