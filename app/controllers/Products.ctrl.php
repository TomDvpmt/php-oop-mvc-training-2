<?php

namespace PhpTraining2\controllers;

use PhpTraining2\core\Controller;
use PhpTraining2\models\Product;
require_once MODELS_DIR . "Product.php";

class Products {

    use Controller;

    public function index() {
        $this->view("pages/products");
    }

    public function add() {

        if(isset($_POST["product-name"])) {
            
            $name = htmlspecialchars($_POST["product-name"]);
            $description = htmlspecialchars($_POST["product-description"]);
            $price = htmlspecialchars($_POST["product-price"]);
            
            if(!empty($name) && !empty($description) && !empty($price)) {
                $product = new Product($name, $description, $price);
                $product->createProduct();
            } else {
                $errorMessage = "Empty fields.";
                $this->view("pages/product-add", $errorMessage, null);
            }
        }
        
        $successMessage = "Product added.";
        $this->view("pages/product-add", null, $successMessage);
    }
}