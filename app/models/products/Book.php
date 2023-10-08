<?php

namespace PhpTraining2\models;

require_once MODELS_DIR . "Product.php";

final class Book extends Product {
    
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