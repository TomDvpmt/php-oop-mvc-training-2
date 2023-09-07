<?php

namespace PhpTraining2\controllers;

use PhpTraining2\core\Controller;
use PhpTraining2\core\Model;
use PhpTraining2\models\Shoe;

require_once MODELS_DIR . "Product.php";

class Products {

    use Controller;
    use Model;

    /**
     * Get an array of all the products from database. 
     * 
     * @access private
     * @package PhpTraining2\controllers
     * @return array
     */

    protected function getAllProducts() {
        $products = $this->findAll();
        return $products;
    }
    

    /**
     * Control the "add product" form page. 
     * 
     * @access public
     * @package PhpTraining2\controllers
     */

    public function add() {

        if(isset($_POST["product-name"])) {
            
            $type = htmlspecialchars($_POST["product-type"]);
            $name = htmlspecialchars($_POST["product-name"]);
            $description = htmlspecialchars($_POST["product-description"]);
            $price = htmlspecialchars($_POST["product-price"]);
            $imgUrl = htmlspecialchars($_POST["product-imgUrl"]);
            $waterproof = htmlspecialchars($_POST["product-waterproof"]);
            $level = htmlspecialchars($_POST["product-level"]);
            
            if(!empty($type) && !empty($name) && !empty($description) && !empty($price)) {

                if($type === "shoe") {
                    $shoe = new Shoe($name, $description, $price, $imgUrl, $waterproof, $level);
                    $shoe->createShoe();
                } elseif($type === "equipment") {
                    //                    
                }
                $successMessage = "Product added.";
                $this->view("pages/product-add", [], null, $successMessage);
                
            } else {
                $errorMessage = "Empty fields.";
                $this->view("pages/product-add", [], $errorMessage, null);
            }
        }

        $this->view("pages/product-add", [], null, null);
    }
}