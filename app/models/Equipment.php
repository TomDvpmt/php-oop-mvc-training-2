<?php

namespace PhpTraining2\models;
require_once "Product.php";

final class Equipment extends Product {
    
    public function __construct(
        protected array $genericData = [],
        protected array $specificData = ["activity" => ""])
    {
        parent::__construct($genericData);
        $this->table = "equipments";
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
            
        <p class="product__activity"><span>Activity : </span><?=$this->specificData["activity"]?></p>
        
        <?php $specificHtml = ob_get_clean();
        return $specificHtml;
    }

}