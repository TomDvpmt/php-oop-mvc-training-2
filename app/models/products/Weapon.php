<?php

namespace PhpTraining2\models\products;

use PhpTraining2\models\products\Product;
use PhpTraining2\models\products\ProductInterface;

final class Weapon extends Product implements ProductInterface {

    public const DEFAULT_SPECIFIC_DATA = ["ideal_range" => "medium"];

    public const SELECT_OPTIONS = [
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