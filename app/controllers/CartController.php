<?php

namespace PhpTraining2\controllers;

use PhpTraining2\core\Controller;
use PhpTraining2\controllers\ProductController;

require_once CTRL_DIR . "ProductController.php";

class CartController {
    use Controller;

    public function __construct(private int $userId = 0, private array $cartItems = [])
    {
        if(!empty($_SESSION["userId"])) {
            $this->userId = $_SESSION["userId"];
        }
    }

    /**
     * Default method of the controller
     * 
     * @access public
     * @package PhpTraining2\controllers
     */

    public function index() {
        $this->initializeCart();
        $this->view("pages/cart");
    }


    /**
     * Initialize the cartItems array in $_SESSION
     * 
     * @access private
     * @package PhpTraining2\controllers
     */

    private function initializeCart(): void {
        if(empty($_SESSION["cartItems"])) {
            $_SESSION["cartItems"] = [];
        }
    }


    /**
     * Add an item to the cart
     * 
     * @access public
     * @package PhpTraining2\controllers
     */

    public function addToCart(): void {
        $this->initializeCart();
        
        $productController = new ProductController();
        $data = $productController->getProductData();
        //
        // TODO : check if item already in cart + manage quantity
        //
        array_push($_SESSION["cartItems"], $data);
    }
}