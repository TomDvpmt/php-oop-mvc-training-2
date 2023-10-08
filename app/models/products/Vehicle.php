<?php

namespace PhpTraining2\models;
require_once MODELS_DIR . "Product.php";

final class Vehicle extends Product {

    private const SELECT_OPTIONS = [
        "questions" => [
            "airborne" => "Can it fly?",
            "aquatic" => "Is it aquatic?"
        ],
        "answers" => [
            "airborne" => [
                "don't try it!",
                "occasionally",
                "oh yeah",
            ],
            "aquatic" => [
                "we don't know, you should try it! (no refund)",
                "reasonnably",
                "definitely"
            ]
        ]
    ];

    public function __construct(
        protected array $genericData = [],
        protected array $specificData = ["airborne" => "occasionally", "aquatic" => "reasonnably"])
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