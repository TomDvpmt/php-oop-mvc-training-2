<?php

namespace PhpTraining2\models\products;

use PhpTraining2\models\Product;

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