<?php

namespace PhpTraining2\controllers;

use PhpTraining2\core\Controller;
use PhpTraining2\controllers\ControllerInterface;
use PhpTraining2\models\Cart;
use PhpTraining2\models\Order;

class OrderController implements ControllerInterface {
    use Controller;

    private Cart $cart;
    
    public function __construct()
    {
        $this->cart = new Cart();
    }

    public function index(): void {
        $this->view("pages/cart");
    }


    /**
     * Display the billing info page
     * 
     * @access public
     * @package PhpTraining2\controllers
     */

    public function billing(): void {
        // TODO : ADD TO ALL PUBLIC FUNCTIONS ?
        // if(!$this->isUserLoggedIn()) {
        //     $this->sendToSigninPage("order?action=billing");
        // }
        $this->view("pages/billing");
    }


    /**
     * Display the recap page (billing info + cart)
     * 
     * @access public
     * @package PhpTraining2\controllers
     */

    public function recap(): void {
        $items = $this->cart->getAllItems();
        $totalPrice = $this->cart->getTotalPrice();
        $billingInfo = $_POST;
        $this->view("pages/recap", ["items" => $items, "billingInfo" => $billingInfo, "totalPrice" => $totalPrice]);
    }


    /**
     * Display the order confirmation page
     * 
     * @access public
     * @package PhpTraining2\controllers
     */

    public function confirm(): void {
        $this->cart->removeAllItems();
        $order = new Order();
        $orderId = $order->getId();

        // Register order in DB

        $this->view("pages/confirmation", ["orderId" => $orderId]);
    }
}