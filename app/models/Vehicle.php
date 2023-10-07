<?php

namespace PhpTraining2\models;
require_once "Product.php";

final class Vehicle extends Product {

    public function __construct(
        protected array $genericData = [],
        protected array $specificData = ["airborne" => "no", "aquatic" => "no"])
    {
        parent::__construct($genericData);
        $this->table = "vehicles";
    }


    /**
     * Get specific shoe html
     * 
     * @access public
     * @package PhpTraning2/models
     * @return string
     */

    public function getProductCardSpecificHtml() {
        ob_start();?>
            
        <p class="product__airborne"><span>Airborne: </span><?=$this->specificData["airborne"]?></p>
        <p class="product__aquatic"><span>Aquatic: </span><?=$this->specificData["aquatic"]?></p>
        
        <?php $specificHtml = ob_get_clean();
        return $specificHtml;
    }
}