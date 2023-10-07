<?php

namespace PhpTraining2\models;
require_once "Product.php";

final class Weapon extends Product {
    
    public function __construct(
        protected array $genericData = [],
        protected array $specificData = ["ideal_range" => ""])
    {
        parent::__construct($genericData);
        $this->table = "weapons";
    }

    /**
     * Get specific equipment html
     * 
     * @access public
     * @package PhpTraning2/models
     * @return string
     */

    public function getProductCardSpecificHtml() {
        ob_start();?>
            
        <p class="product__ideal_range"><span>Range: </span><?=$this->specificData["ideal_range"]?></p>
        
        <?php $specificHtml = ob_get_clean();
        return $specificHtml;
    }

}