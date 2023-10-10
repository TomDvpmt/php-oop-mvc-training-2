<?php

namespace PhpTraining2\models\products;

use PhpTraining2\models\Product;
use PhpTraining2\models\ProductInterface;

final class Weapon extends Product implements ProductInterface {

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

    public function getSelectOptions(): array {
        return self::SELECT_OPTIONS;
    }

}