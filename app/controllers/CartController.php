<?php

namespace PhpTraining2\controllers;

use PhpTraining2\core\Controller;
use PhpTraining2\models\Cart;
use PhpTraining2\models\Product;
use PhpTraining2\models\Order;

require_once CTRL_DIR . "ProductController.php";
require_once MODELS_DIR . "Cart.php";
require_once MODELS_DIR . "Order.php";

class CartController {
    use Controller;

    public function __construct(private int $userId = 0, private array $cartItems = [])
    {
        if(!empty($_SESSION["user"]["id"])) {
            $this->userId = $_SESSION["user"]["id"];
        }
    }

    /**
     * Default method of the controller
     * 
     * @access public
     * @package PhpTraining2\controllers
     */

    public function index() {
        (new Order)->removeIdFromSession();

        $cart = new Cart($this->cartItems);
        $items = $cart->getAllItems();
        $totalPrice = $cart->getTotalPrice();
        $this->view("pages/cart", ["items" => $items, "totalPrice" => $totalPrice]);
    }


    /**
     * Add an item to the cart
     * 
     * @access public
     * @package PhpTraining2\controllers
     */

    public function add(): void {
        $cart = new Cart($this->cartItems);
        $product = new Product();
        $data = $product->getProductData();
        if($cart->getOneItem($data["id"])) {
            $this->index(); // TODO : error message
        } else {
            $cart->addItem([...$data, "quantity" => 1]);
            $this->index();
        }
    }

    /**
     * Update an item's quantity
     * 
     * @access public
     * @package PhpTraining2\controllers
     */
    
    public function updateQuantity(): void {
        $productId = strip_tags($_GET["id"]);
        $newQuantity = strip_tags($_POST["quantity"]);
        $cart = new Cart($this->cartItems);
        $cart->updateItemQuantity($productId, $newQuantity);
        $this->index();
    }


    /**
     * Remove an item from the cart
     * 
     * @access public
     * @package PhpTraining2\controllers
     */

    public function remove() {
        $productId = strip_tags($_GET["id"]);
        $cart = new Cart($this->cartItems);
        $cart->removeItem($productId);
        $this->index();
    }
}