<?php

namespace PhpTraining2\controllers;

use PhpTraining2\core\Controller;
use PhpTraining2\core\ControllerInterface;
use PhpTraining2\models\Cart;
use PhpTraining2\models\Order;

class CartController implements ControllerInterface {
    use Controller;

    public function __construct(private int $userId = 0, private array $cartItems = [])
    {
        if(!empty($_SESSION["user"]["id"])) {
            $this->userId = $_SESSION["user"]["id"];
        }
    }

    public function index():void {
        if(isset($_SESSION["orderId"])) {
            (new Order)->removeIdFromSession();
        }
        $this->executeMethodIfExists();
        $this->displayCart();
    }

    /**
     * Display cart
     * 
     * @access private
     * @package PhpTraining2\controllers
     */
    
    private function displayCart() {
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
        $category = $_GET["category"];
        $model = "PhpTraining2\models\products\\" . getModelNameFromTableName($category);

        $cart = new Cart($this->cartItems);
        $product = new $model();
        $data = $product->getProductDataFromDB();

        if($cart->getOneItem($data["genericData"]["id"])) {
            // TODO : error message
        } else {
            $cart->addItem([...$data, "quantity" => 1]);
        }
        
        $this->displayCart();
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
        $this->displayCart();
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
        $this->displayCart();
    }
}