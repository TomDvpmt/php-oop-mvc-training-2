<?php

namespace PhpTraining2\models;
require_once "Product.php";

final class Equipment extends Product {
    
    public function __construct(
        protected int $id,
        protected string $type,
        protected string $name, 
        protected string $description, 
        protected int $price, 
        protected string $imgUrl, 
        protected string $activity = "",
        )
    {
        parent::__construct($id, $type, $name, $description, $price, $imgUrl);
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
            
        <p class="product__activity"><span>Activity : </span><?=$this->activity?></p>
        
        <?php $specificHtml = ob_get_clean();
        return $specificHtml;
    }

}