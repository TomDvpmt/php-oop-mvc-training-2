<?php

namespace PhpTraining2\models;
require_once MODELS_DIR . "Product.php";

final class Shoe extends Product {

    private const SELECT_OPTIONS = [
        "questions" => [
            "waterproof" => "Is the shoe waterproof?",
            "usage_intensity" => "What is the maximum usage intensity of this shoe?"
        ],
        "answers" => [
            "waterproof" => [
                "of course not",
                "unsure",
                "absolutely",
            ],
            "usage_intensity" => [
                "once every few centuries",
                "on sundays only",
                "hero level"
            ]
        ]
    ];

    public function __construct(
        protected array $genericData = [],
        protected array $specificData = ["waterproof" => "unsure", "usage_intensity" => "on sundays only"])
    {
        parent::__construct($genericData);
        $this->table = "shoes";
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