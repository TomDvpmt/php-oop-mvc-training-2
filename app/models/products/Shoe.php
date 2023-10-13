<?php

namespace PhpTraining2\models\products;

use PhpTraining2\models\Product;
use PhpTraining2\models\ProductInterface;

final class Shoe extends Product implements ProductInterface {
    
    private const DEFAULT_SPECIFIC_DATA = ["waterproof" => "unsure", "usage_intensity" => "on sundays only"];

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
        protected array $specificData = self::DEFAULT_SPECIFIC_DATA)
    {
        parent::__construct($genericData);
        $this->setTable("shoes");
    }

    public function getSelectOptions(): array {
        return self::SELECT_OPTIONS;
    }
}