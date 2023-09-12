<?php

namespace PhpTraining2\controllers;

use PhpTraining2\core\Controller;

class Cart {
    use Controller;

    public function __construct(private int $userId = 0, private array $products = [])
    {
        if(!empty($_SESSION["userId"])) {
            $this->userId = $_SESSION["userId"];
        }
    }

    public function index() {
        $this->view("pages/cart");
    }

    public function addToCart(array $product) {
        //
    }
}