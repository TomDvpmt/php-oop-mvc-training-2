<?php

namespace PhpTraining2\models;
require_once "Product.php";

final class Shoe extends Product {

    public function __construct(
        protected array $genericData = [],
        protected array $specificData = ["waterproof" => 0, "level" => "regular"])
    {
        parent::__construct($genericData);
        $this->table = "shoes";
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
            
        <p class="product__waterproof"><span>Waterproof : </span><?=$this->specificData["waterproof"] === 0 ? "no" : "yes" ?></p>
        <p class="product__level"><span>Practice level : </span><?=$this->specificData["level"]?></p>
        
        <?php $specificHtml = ob_get_clean();
        return $specificHtml;
    }
}