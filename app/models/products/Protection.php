<?php

namespace PhpTraining2\models;
require_once MODELS_DIR . "Product.php";

final class Protection extends Product {

    private const SELECT_OPTIONS = [
        "questions" => [
            "type" => "What kind of protection is this beauty?",
            "resistance" => "How resistant is it?"
        ],
        "answers" => [
            "type" => [
                "helmet",
                "armor",
                "clothing",
                "plot armor",
                "hard to say"
            ],
            "resistance" => [
                "the dangerously weak kind",
                "medium",
                "it's an impenetrable wall"
            ]
        ]
    ];
    
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


    /**
     * Get select options for add product form
     * 
     * @access public
     * @package PhpTraning2/models
     * @return array
     */

     public function getSelectOptions(): array {
        return self::SELECT_OPTIONS;
    }

}