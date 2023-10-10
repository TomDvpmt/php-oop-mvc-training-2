<?php

namespace PhpTraining2\models\products;

use PhpTraining2\models\Product;
use PhpTraining2\models\ProductInterface;

final class Book extends Product implements ProductInterface {
    
    private const SELECT_OPTIONS = [
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
        protected array $specificData = ["genre" => "fantasy"])
    {
        parent::__construct($genericData);
        $this->table = "books";
    }

    public function getSelectOptions(): array {
        return self::SELECT_OPTIONS;
    }

}