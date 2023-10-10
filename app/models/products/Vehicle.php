<?php

namespace PhpTraining2\models\products;

use PhpTraining2\models\Product;
use PhpTraining2\models\ProductInterface;

final class Vehicle extends Product implements ProductInterface {

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

    public function getSelectOptions(): array {
        return self::SELECT_OPTIONS;
    }
}