<?php

namespace PhpTraining2\models;
require_once "Product.php";

final class Book extends Product {
    
    private array $selectOptions = [
        "questions" => ["genre" => "Which genre better defines this book?"],
        "answers" => [
            "genre" => 
                ["based on true events",
                "fantasy",
                "myth",
                "science-fiction",
                "it's a blend"]
        ]
    ];

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
    

    /**
     * Get select options for add product form
     * 
     * @access public
     * @package PhpTraning2/models
     * @return array
     */

    public function getSelectOptions(): array {
        return $this->selectOptions;
    }

}