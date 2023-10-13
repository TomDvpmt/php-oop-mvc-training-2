<?php

namespace PhpTraining2\models\products;

use PhpTraining2\models\Product;
use PhpTraining2\models\ProductInterface;

final class Weapon extends Product implements ProductInterface {

    private const DEFAULT_SPECIFIC_DATA = ["ideal_range" => "medium"];

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
        protected array $specificData = self::DEFAULT_SPECIFIC_DATA)
    {
        parent::__construct($genericData);
        $this->setTable("weapons");
    }

    public function getSelectOptions(): array {
        return self::SELECT_OPTIONS;
    }

}