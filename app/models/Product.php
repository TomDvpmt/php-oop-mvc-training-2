<?php

namespace PhpTraining2\models;

use PhpTraining2\core\Model;

abstract class Product {
    use Model;
    
    public function __construct(
        protected int $id,
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

    public function getProductHtml($specificHtml) {
        ob_start();
        require VIEWS_DIR . "partials/product-card.php";
        $html = ob_get_clean();

        return $html;
    }

    /**
     * Add a product
     * 
     * @access public
     * @package PhpTraining2\controllers
     */

    public function createProduct($specificData) {
        $genericData = [
            "name" => $this->name,
            "description" => $this->description,
            "price" => $this->price,
            "img_url" => $this->imgUrl,
        ];
        $data = array_merge($genericData, $specificData);
        $this->create($data);
    }

    

    public function updateProduct($id, $updateData) {
        //
    }

    public function deleteProduct($id) {
        //
    }
}