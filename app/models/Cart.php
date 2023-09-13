<?php

namespace PhpTraining2\models;

use PhpTraining2\core\Model;

class Cart {
    use Model;

    public function __construct(private int $userId = 0, private array $cartItems = [])
    {
        if(!isset($_SESSION["userId"])) {
            $_SESSION["userId"] = $this->userId;
        }
        if(!isset($_SESSION["cartItems"])) {
            $_SESSION["cartItems"] = $this->cartItems;
        }
    }

    /**
     * Get all cart items from $_SESSION
     *
     * @access public
     * @package PhpTraining2\models
     * @return array
     */

    public function getAllItems(): array {
        return $_SESSION["cartItems"];
    }


    /**
     * Add an item to the cart
     * 
     * @access public
     * @package PhpTraining2\models
     * @param array $data An array containing the item's data
     */

    public function addItem(array $data): void {
        $this->updateInSession("cartItems", [...$_SESSION["cartItems"], $data]);
    }


    /**
     * Remove an item from the cart
     * 
     * 
     */

    public function removeItem(int $id) {
        $items = $this->getAllItems();
        $targetPos = array_search(["id" => $id], $items);
        array_splice($_SESSION["cartItems"], $targetPos, 1);
    }

}