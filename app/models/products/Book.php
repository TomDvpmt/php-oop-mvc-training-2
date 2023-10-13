<?php

namespace PhpTraining2\models\products;

use PhpTraining2\models\Product;
use PhpTraining2\models\ProductInterface;

final class Book extends Product implements ProductInterface {

    public const DEFAULT_SPECIFIC_DATA = ["genre" => "fantasy"];
    
    public const SELECT_OPTIONS = [
        "questions" => ["genre" => "Which genre better defines this book?"],
        "answers" => [
            "genre" => 
                ["based on true events",
                "fantasy",
                "myth",
                "science-fiction",
                "it's a blend"]
        ]
    ];

    public function __construct(
        protected array $genericData = [],
        protected array $specificData = self::DEFAULT_SPECIFIC_DATA)
    {
        parent::__construct($genericData);
        $this->setTable("books");
    }

    public function getSelectOptions(): array {
        return self::SELECT_OPTIONS;
    }

}