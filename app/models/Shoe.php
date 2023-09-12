<?php

namespace PhpTraining2\models;
require_once "Product.php";

final class Shoe extends Product {

    public function __construct(
        protected int $id,
        protected string $category, 
        protected string $name, 
        protected string $description, 
        protected int $price, 
        protected string $imgUrl, 
        protected int $waterproof = 0, 
        protected string $level = "regular")
    {
        parent::__construct($id, $category, $name, $description, $price, $imgUrl);
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
            
        <p class="product__waterproof"><span>Waterproof : </span><?=$this->waterproof === 0 ? "no" : "yes" ?></p>
        <p class="product__level"><span>Practice level : </span><?=$this->level?></p>
        
        <?php $specificHtml = ob_get_clean();
        return $specificHtml;
    }
}