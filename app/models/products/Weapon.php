<?php

namespace PhpTraining2\models;
require_once MODELS_DIR . "Product.php";

final class Weapon extends Product {

    private const SELECT_OPTIONS = [
        "questions" => ["ideal_range" => "What is the ideal range for this weapon?"],
        "answers" => [
            "ideal_range" => [
                "way too short",
                "medium",
                "a cowardly yet comfortable long distance",
            ]
        ]
    ];
    
    public function __construct(
        protected array $genericData = [],
        protected array $specificData = ["ideal_range" => "medium"])
    {
        parent::__construct($genericData);
        $this->table = "weapons";
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