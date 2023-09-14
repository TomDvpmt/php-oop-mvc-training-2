<?php

namespace PhpTraining2\controllers;

use PhpTraining2\core\Controller;
use PhpTraining2\models\Cart;
use PhpTraining2\models\Order;

require_once MODELS_DIR . "Cart.php";
require_once MODELS_DIR . "Order.php";

class OrderController {
    use Controller;

    public function index(): void {
        $this->view("pages/cart");
    }

    public function billing(): void {
        // if(!$this->isUserLoggedIn()) {
        //     $this->sendToLoginPage("order?action=billing");
        // }
        $this->view("pages/billing");
    }

    public function recap(): void {
        $cart = (new Cart())->getAllItems();
        $totalPrice = (new Order)->getTotalPrice();
        $billingInfo = $_POST;
        $this->view("pages/recap", ["cart" => $cart, "billingInfo" => $billingInfo, "totalPrice" => $totalPrice]);
    }

    public function pay() {
        // generate a random alphanumeric order identifier
    }
}