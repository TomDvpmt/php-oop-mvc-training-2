<?php

namespace PhpTraining2\models;

use PhpTraining2\core\Model;
use PhpTraining2\models\ProductInterface;

abstract class Product implements ProductInterface {
    use Model;
    
    public function __construct(
        protected array $genericData = [
            "id" => 0,
            "category" => "", 
            "name" => "", 
            "description" => "", 
            "special_features" => "",
            "limitations" => "",
            "price" => 0, 
            "thumbnail" => ""
        ],
    ) {
        $last = getURI()["last"];
        if(isset($_GET["id"])) {
            $this->genericData["id"] = intval(strip_tags($_GET["id"]));
        }
        if(intval($last)) {
            $this->genericData["id"] = $last;
        }
        if(isset($_GET["category"])) {
            $this->genericData["category"] = strip_tags($_GET["category"]);
        }
    }

    public function getProductData(): array {
        $genericData = $this->getProductGenericData();
        $specificData = $this->getProductSpecificData();
        $data = ["genericData" => $genericData, "specificData" => $specificData];
        return $data;
    }

    /**
     * Get the product's generic data (id, name, description, special_features, limitations, price, image url)
     * 
     * @access private
     * @package PhpTraining2\models
     * @return array
     */

    private function getProductGenericData(): array {
        $this->columns = "id, category, name, description, special_features, limitations, price, thumbnail";
        $this->table = "products";
        $this->where = "id = :id";
        $genericData = (array) $this->find(["id" => $this->genericData["id"]])[0];
        return $genericData;
    }


    /**
     * Get the product's specific data (depending on its category)
     * 
     * @access private
     * @package PhpTraining2\models
     * @return array
     */
    
    private function getProductSpecificData(): array {
        $this->columns = "*";
        $this->table = $this->genericData["category"];
        $this->where = "product_id= :product_id";
        $data = (array) $this->find(["product_id" => $this->genericData["id"]])[0];
        $specificData = array_filter($data, fn($key) => !in_array($key, ["id", "product_id"]), ARRAY_FILTER_USE_KEY);
        return $specificData;
    }
    

    /**
     * Add an item to the "products" table and return its id
     * 
     * @access private
     * @package PhpTraining2\models
     * @return int
     */

    private function createGenericProduct(): int {
        $this->table = "products";
        $genericData = [
            "category" => $this->genericData["category"],
            "name" => $this->genericData["name"],
            "description" => $this->genericData["description"],
            "special_features" => $this->genericData["special_features"],
            "limitations" => $this->genericData["limitations"],
            "price" => $this->genericData["price"],
            "thumbnail" => $this->genericData["thumbnail"],
        ];
        $this->create($genericData);   
        $id = $this->getLastInsertId();
        return $id;
    }

    /**
     * Add an item to a child table of "products" table ("books", "shoes", etc.)
     * 
     * @access public
     * @package PhpTraining2\models
     */

    public function createSpecificProduct(array $data): void {
        $id = $this->createGenericProduct();

        $this->table = $this->genericData["category"];
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

    public function getProductCardHtml(): string {
        $specificHtml = $this->getProductCardSpecificHtml();

        ob_start();
        require VIEWS_DIR . "partials/product-card.php";
        $cardHtml = ob_get_clean();
        
        return $cardHtml;
    }


    /**
     * Get product card specific HTML
     * 
     * @access private
     * @package PhpTraning2/models
     * @return string
     */

     private function getProductCardSpecificHtml(): string {
        $specificHtml = [];
        $specificData = $this->getProductSpecificData();
        foreach ($specificData as $key => $value) {
            $label = ucfirst($key);
            array_push($specificHtml, "<p class='product__$key'><span>$label: </span>$value</p>");
        }

        return implode("", $specificHtml);
    }
}