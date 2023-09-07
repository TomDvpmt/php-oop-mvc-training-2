<?php

namespace PhpTraining2\models;

use PhpTraining2\core\Model;

abstract class Product {
    use Model;
    
    public function __construct(
        protected string $name = "", 
        protected string $description = "", 
        protected int $price = 0, 
        protected string $imgUrl = "")
    {}

    /**
     * Get HTML code for a product
     * 
     * @access public
     * @package PhpTraining2\controllers
     * @param array product 
     * @return string
     */

    public function getProductHtml() {
        return "<article class='product'>
        <h2 class='product__name'>" . strip_tags($this->name) . "</h2>
        <p class='product__price'>$ " . strip_tags($this->price) . "</p>
        </article>";
    }

    // /**
    //  * Add a product
    //  * 
    //  * @access public
    //  * @package PhpTraining2\controllers
    //  */

    // public function createProduct() {
    //     $data = [
    //         "name" => $this->name,
    //         "description" => $this->description,
    //         "price" => $this->price
    //     ];
    //     $this->create($data);
    // }

    

    public function updateProduct($id, $updateData) {
        //
    }

    public function deleteProduct($id) {
        //
    }
}