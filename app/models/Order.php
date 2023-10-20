<?php

namespace PhpTraining2\models;

use PhpTraining2\models\Cart;

class Order {
    private string $id = "";
    private array $items = [];

    public function __construct()
    {
        if(!isset($_SESSION["orderId"])) {
            $this->id = $this->generateOrderId(); // TODO : replace with DB id
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
            unset($_SESSION["orderId"]);
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


    /**
     * Generate an alphanumeric order id
     * 
     * @return string A concatenated string of userId + timestamp + random string(s)
     */

    function generateOrderId(): string {
        $numberOfRandomStrings = 1;
        $lengthOfRandomString = 5;
        $userId = $_SESSION["userId"];
        $timeStamp = time();
        
        $idParts = [$userId, $timeStamp];

        for($i = 0 ; $i < $numberOfRandomStrings ;$i++) {
            $idParts[] = getRandomString($lengthOfRandomString);
        }

        return implode("-", $idParts);
    }
}