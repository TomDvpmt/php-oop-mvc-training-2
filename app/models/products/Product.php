<?php

namespace PhpTraining2\models\products;

use Exception;
use PhpTraining2\core\Model;
use PhpTraining2\exceptions\FileDeleteException;
use PhpTraining2\exceptions\ProductCreateException;
use PhpTraining2\exceptions\ProductGetDataException;
use PhpTraining2\models\products\ProductInterface;

abstract class Product implements ProductInterface {
    use Model;

    public const GENERIC_PROPERTIES = [
        "name" => "text", 
        "description" => "text", 
        "special_features" => "text", 
        "limitations" => "text", 
        "price" => "number"
    ];
    public const REQUIRED_GENERIC_PROPERTIES = ["name", "description", "price"];
    public const PRODUCTS_THUMBS_DIR = "assets/images/products/";
    public const DEFAULT_THUMBNAIL = "default_product_thumbnail.webp"; // TODO: put a default img in the default folder
    
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
            $id = intval(strip_tags($_GET["id"]));
            $this->setId($id);
        }
        if(intval($last)) {
            $this->setId($last);
        }
        if(isset($_GET["category"])) {
            $category = strip_tags($_GET["category"]);
            $this->setCategory($category);
        }
    }

    /**
     * Set product's id
     * 
     * @access private
     * @package PhpTraning2\models\products
     * @param int $id
     */

     public function setId(int $id): void {
        $this->genericData["id"] = $id;
    }


    /**
     * Set product's category
     * 
     * @access private
     * @package PhpTraning2\models\products
     * @param string $category
     */

     public function setCategory(string $category): void {
        $this->genericData["category"] = $category;
    }

    /**
     * @see ProductInterface
     */

    public function getProductDataFromDB(): array {
        $genericData = $this->getGenericDataFromDB();
        $specificData = $this->getSpecificDataFromDB();
        return ["genericData" => $genericData, "specificData" => $specificData];
    }

    /**
     * Get product's generic data
     * 
     * @access private
     * @package PhpTraining2\models\products
     */

    private function getGenericData(): array {
        $genericData = [
            "category" => $this->genericData["category"],
            "name" => $this->genericData["name"],
            "description" => $this->genericData["description"],
            "special_features" => $this->genericData["special_features"],
            "limitations" => $this->genericData["limitations"],
            "price" => $this->genericData["price"],
            "thumbnail" => $this->genericData["thumbnail"],
        ];
        return $genericData;
    }

    /**
     * Set product's generic data
     * 
     * @access public
     * @package PhpTraining2\models\products
     */

    public function setGenericData($data): void {
        $this->genericData = $data;
    }

    /**
     * Get the product's generic data (id, name, description, special_features, limitations, price, image url)
     * 
     * @access private
     * @package PhpTraining2\models\products
     * @return array
     */

    private function getGenericDataFromDB(): array {
        $this->setTable("products");
        $allGenericProperties = array_merge(["id", "category", "thumbnail"], array_keys(self::GENERIC_PROPERTIES));
        $columns = implode(", ", $allGenericProperties);
        $this->setColumns($columns);
        $this->setWhere("id = :id");
        $genericData = (array) $this->find(["id" => $this->genericData["id"]])[0];
        if(!$genericData || empty($genericData)) {
            throw new ProductGetDataException("generic");
        }
        return $genericData;
    }


    /**
     * Get the product's specific data (depending on its category)
     * 
     * @access private
     * @package PhpTraining2\models\products
     * @return array
     */
    
    private function getSpecificDataFromDB(): array {
        $this->setTable($this->genericData["category"]);
        $this->setColumns("*");
        $this->setWhere("product_id= :product_id");
        $data = (array) $this->find(["product_id" => $this->genericData["id"]])[0];
        if(!$data || empty($data)) {
            throw new ProductGetDataException("specific");
        }
        $specificData = array_filter($data, fn($key) => !in_array($key, ["id", "product_id"]), ARRAY_FILTER_USE_KEY);
        return $specificData;
    }
    

    /**
     * Add an item to a child table of "products" table ("books", "shoes", etc.)
     * 
     * @access public
     * @package PhpTraining2\models\products
     * @param array $data
     */

    public function createProduct(array $data): void {
        $id = $this->createAbstractProduct();
        $specificData = array_merge(["product_id" => $id], $data);

        $this->setTable($this->genericData["category"]);
        $this->setOrderColumn("product_id");
        
        try {
            $this->create($specificData);
        } catch (Exception) {
            throw new ProductCreateException("specific");
        }
    }


    /**
     * Add an item to the "products" table
     * 
     * @access private
     * @package PhpTraining2\models\products
     * @return int The item's id
     */

     private function createAbstractProduct(): int {
        $genericData = $this->getGenericData();
        $this->setTable("products");

        try {
            $this->create($genericData);
        } catch (Exception) {
            throw new ProductCreateException("generic");
        }
        $id = $this->getLastInsertId();
        return $id;
    }


    /**
     * Get HTML code for a product
     * 
     * @access public
     * @package PhpTraining2\models\products
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
     * @package PhpTraning2\models\products
     * @return string
     */

     private function getProductCardSpecificHtml(): string {
        $specificHtml = [];
        $specificData = $this->getSpecificDataFromDB();
        foreach ($specificData as $key => $value) {
            $label = ucfirst($key);
            $specificHtml[] = "<p class='product__$key'><span>$label: </span>$value</p>";
        }

        return implode("", $specificHtml);
    }

    /**
     * Delete thumbnail file
     * 
     * @access public
     * @package PhpTraning2\models\products
     */

    public function deleteThumbnailFile(): void {
        $productData = $this->getProductDataFromDB();
        $path = self::PRODUCTS_THUMBS_DIR . $productData["genericData"]["thumbnail"];
        unlink($path) ?? throw new FileDeleteException();
    }


    /**
     * Remove a product from database
     * 
     * @access public
     * @package PhpTraning2\models\products
     */

    public function removeProductFromDB() {
        $id = strip_tags($_GET["id"]);
        $this->delete("product_id", $id);
    }
}