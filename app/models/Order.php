<?php

namespace PhpTraining2\models;

require_once MODELS_DIR . "Cart.php";

use PhpTraining2\models\Cart;

class Order {
    private string $id = "";
    private array $items = [];

    public function __construct()
    {
        if(!isset($_SESSION["orderId"])) {
            $this->id = generateRandomId();
            $_SESSION["orderId"] = $this->id;
        } else {
            $this->id = $_SESSION["orderId"];
        }
        
        
        $cart = new Cart();
        $this->items = $cart->getAllItems();
    }

    /**
     * Get id of this Order instance
     * 
     * @access public
     * @package PhpTraining2\models
     * @return string
     */

    public function getId(): string {
        return $this->id;
    }

    
    /**
     * Remove the order id from session
     * 
     * @access public
     * @package PhpTraining2\models
     */

    public function removeIdFromSession(): void {
        if(isset($_SESSION["orderId"])) {
            $_SESSION["orderId"] = null;
        };
    }


    /**
     * Get items of this Order instance
     * 
     * @access public
     * @package PhpTraining2\models
     * @return array
     */

    public function getItems(): array {
        return $this->items;
    }
}