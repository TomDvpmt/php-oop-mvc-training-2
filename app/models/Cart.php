<?php

namespace PhpTraining2\models;

use PhpTraining2\core\Model;

class Cart {
    use Model;

    private int $totalPrice;

    public function __construct(private array $cartItems = [])
    {
        if(!isset($_SESSION["cart"])) {
            $_SESSION["cart"] = $this->cartItems;
        }
        $this->totalPrice = array_sum(array_map(fn($item) => $item["genericData"]["price"] * $item["quantity"], $_SESSION["cart"]));
    }

    /**
     * Get all cart items
     *
     * @access public
     * @package PhpTraining2\models
     * @return array
     */

    public function getAllItems(): array {
        return $_SESSION["cart"];
    }


    /**
     * Get a cart item's data
     * 
     * @access public
     * @package PhpTraining2\models
     * @param int $id
     * @return array
     */

    public function getOneItem(int $id): array {
        return array_filter($_SESSION["cart"], fn($item) => $item["genericData"]["id"] === $id);
    }


    /**
     * Add an item to the cart
     * 
     * @access public
     * @package PhpTraining2\models
     * @param array $data An array containing the item's data
     */

    public function addItem(array $data): void {
        $this->updateInSession("cart", [...$_SESSION["cart"], $data]);
    }


    /**
     * Update cart item's quantity
     * 
     * @access public
     * @package PhpTraining2\models
     * @param int $id The item's id
     * @param int $newQuantity
     */

    public function updateItemQuantity(int $id, int $newQuantity): void {
        $allItems = $this->getAllItems();
        foreach($allItems as $key => $item) {
            if($item["genericData"]["id"] === $id) {
                $_SESSION["cart"][$key]["quantity"] = $newQuantity;
                return;
            }
        }
    }


    /**
     * Remove an item from the cart
     * 
     * @access public
     * @package PhpTraining2\models
     * @param int $productId
     */

    public function removeItem(int $productId): void {
        $items = $this->getAllItems();
        $newItems = array_filter($items, fn($item) => $item["genericData"]["id"] != $productId);
        $_SESSION["cart"] = $newItems;
    }

    
    /**
     * Remove all items from cart
     * 
     * @access public
     * @package PhpTraining2\models
     */

    public function removeAllItems() {
        $_SESSION["cart"] = [];
    }


    /**
     * Get the cart's total price
     * 
     * @access public
     * @package PhpTraining2\models
     * @return int
     */

     public function getTotalPrice(): int {
        return $this->totalPrice;
    }

}