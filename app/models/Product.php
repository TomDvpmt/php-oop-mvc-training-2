<?php

namespace PhpTraining2\models;

use PhpTraining2\core\Model;

class Product {
    use Model;
    
    public function __construct(private string $name = "", private string $description = "", private int $price = 0)
    {
        $this->table = "products";
    }

    /**
     * Get HTML code for a product
     * 
     * @access private
     * @package PhpTraining2\controllers
     * @param array product 
     * @return string
     */

    public function getProductHtml() {
        return "<article>
        <h2>" . strip_tags($this->name) . "</h2>
        <p>" . strip_tags($this->description) . "</p>
        <p>$ " . strip_tags($this->price) . "</p>
        </article>";
    }

    /**
     * Add a product
     */

    public function createProduct() {
        $data = [
            "name" => $this->name,
            "description" => $this->description,
            "price" => $this->price
        ];
        $this->create($data);
    }

    public function updateProduct($id, $updateData) {
        //
    }

    public function deleteProduct($id) {
        //
    }
}