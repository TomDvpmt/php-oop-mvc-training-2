<?php

namespace PhpTraining2\models;



class Order {
    private int $totalPrice = 0;
    private array $items = [];

    private function getItems(): array {
        return (new Cart())->getAllItems();
    } 

    public function getTotalPrice() {
        $items = $this->getItems();
        $totalPrice = array_reduce($items, fn($acc, $item) => $acc + ($item["price"] * $item["quantity"]), 0);
        return $totalPrice;
    }
}