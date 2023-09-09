<?php

namespace PhpTraining2\models;

use PhpTraining2\core\Model;

abstract class Product {
    use Model;
    
    public function __construct(
        protected int $id = 0,
        protected string $type = "", 
        protected string $name = "", 
        protected string $description = "", 
        protected int $price = 0, 
        protected string $imgUrl = "")
    {}

    /**
     * Get HTML code for a product
     * 
     * @access public
     * @package PhpTraining2\models
     * @param array product 
     * @return string
     */

    public function getProductHtml($specificHtml) {
        ob_start();
        require VIEWS_DIR . "partials/product-card.php";
        $html = ob_get_clean();

        return $html;
    }

    /**
     * Add an item to the "products" table and return its id
     * 
     * @access public
     * @package PhpTraining2\models
     * @return int
     */

    public function createGenericProduct() {
        $this->table = "products";
        $genericData = [
            "type" => $this->type,
            "name" => $this->name,
            "description" => $this->description,
            "price" => $this->price,
            "img_url" => $this->imgUrl,
        ];
        $this->create($genericData);   
        $id = $this->getLastInsertId();
        return $id;
    }

    public function createSpecificProduct($data) {
        $id = $this->createGenericProduct();

        $this->table = $this->type . "s";
        $this->orderColumn = "product_id";
        $specificData = array_merge(["product_id" => $id], $data);

        $this->create($specificData);
    }

    

    public function updateProduct($id, $updateData) {
        //
    }

    public function deleteProduct($id) {
        //
    }
}