<?php

namespace PhpTraining2\models;
require_once "Product.php";

final class Protection extends Product {
    
    public function __construct(
        protected array $genericData = [],
        protected array $specificData = ["type" => "", "resistance" => "medium"])
    {
        parent::__construct($genericData);
        $this->table = "protection";
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
            
        <p class="product__type"><span>Type: </span><?=$this->specificData["type"]?></p>
        <p class="product__resistance"><span>Resistance: </span><?=$this->specificData["resistance"]?></p>
        
        <?php $specificHtml = ob_get_clean();
        return $specificHtml;
    }

}