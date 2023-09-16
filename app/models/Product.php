<?php

namespace PhpTraining2\models;

use PhpTraining2\core\Model;

class Product {
    use Model;
    
    public function __construct(
        protected array $genericData = [
            "id" => 0,
            "category" => "", 
            "name" => "", 
            "description" => "", 
            "price" => 0, 
            "img_url" => ""
        ],
    ) {
        if(isset($_GET["id"])) {
            $this->genericData["id"] = intval(strip_tags($_GET["id"]));
        }
        if(isset($_GET["category"])) {
            $this->genericData["category"] = strip_tags($_GET["category"]);
        }
    }

    /**
     * Get the product's full data (generic + specific)
     * 
     * @access public
     * @package PhpTraining2\models
     * @return array
     */

     public function getProductData(): array {
        
        $genericData = $this->getProductGenericData();
        $specificData = $this->getProductSpecificData();
        $data = array_merge($genericData, $specificData);
        return $data;
    }

    /**
     * Get the product's generic data (id, name, description, price, image url)
     * 
     * @access public
     * @package PhpTraining2\models
     * @return array
     */

     public function getProductGenericData(): array {
        $this->columns = "id, name, description, price, img_url";
        $this->table = "products WHERE id = :id";
        $genericData = (array) $this->find(["id" => $this->genericData["id"]])[0];
        return $genericData;
    }


    /**
     * Get the product's specific data (depending on its category)
     * 
     * @access public
     * @package PhpTraining2\models
     * @return array
     */

    public function getProductSpecificData(): array {
        $this->columns = "*";
        $this->table = $this->genericData["category"] . "s WHERE product_id= :product_id";
        $data = (array) $this->find(["product_id" => $this->genericData["id"]])[0];
        $specificData = array_filter($data, fn($key) => !in_array($key, ["id", "product_id"]), ARRAY_FILTER_USE_KEY);
        return $specificData;
    }

    /**
     * Add an item to the "products" table and return its id
     * 
     * @access protected
     * @package PhpTraining2\models
     * @return int
     */

    protected function createGenericProduct(): int {
        $this->table = "products";
        $genericData = [
            "category" => $this->genericData["category"],
            "name" => $this->genericData["name"],
            "description" => $this->genericData["description"],
            "price" => $this->genericData["price"],
            "img_url" => "",
        ];
        $this->create($genericData);   
        $id = $this->getLastInsertId();
        return $id;
    }

    /**
     * Add an item to a child table of "products" table ("shoes", "equipments", etc.)
     * 
     * @access public
     * @package PhpTraining2\models
     */

    public function createSpecificProduct(array $data): void {
        $id = $this->createGenericProduct();

        $this->table = $this->genericData["category"] . "s";
        $this->orderColumn = "product_id";
        $specificData = array_merge(["product_id" => $id], $data);

        $this->create($specificData);
    }


    /**
     * Get HTML code for a product
     * 
     * @access public
     * @package PhpTraining2\models
     * @return string
     */

     public function getProductCardHtml(string $specificHtml): string {
        ob_start();
        require VIEWS_DIR . "partials/product-card.php";
        $cardHtml = ob_get_clean();
        
        return $cardHtml;
    }
}