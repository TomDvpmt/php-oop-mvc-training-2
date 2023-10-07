<?php

namespace PhpTraining2\models;
require_once "Product.php";

final class Book extends Product {
    
    public function __construct(
        protected array $genericData = [],
        protected array $specificData = ["genre" => ""])
    {
        parent::__construct($genericData);
        $this->table = "books";
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
            
        <p class="product__genre"><span>Genre: </span><?=$this->specificData["genre"]?></p>
        
        <?php $specificHtml = ob_get_clean();
        return $specificHtml;
    }

}