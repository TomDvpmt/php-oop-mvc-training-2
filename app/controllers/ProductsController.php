<?php

namespace PhpTraining2\controllers;

use PhpTraining2\core\Controller;
use PhpTraining2\core\Model;
use PhpTraining2\models\ProductCategory;

require_once MODELS_DIR . "ProductCategory.php";
require_once MODELS_DIR . "Form.php";
require_once MODELS_DIR . "products/Book.php";
require_once MODELS_DIR . "products/Protection.php";
require_once MODELS_DIR . "products/Shoe.php";
require_once MODELS_DIR . "products/Vehicle.php";
require_once MODELS_DIR . "products/Weapon.php";

abstract class ProductsController {

    use Controller;
    use Model;

    protected string $category = "";
    protected string $model;
    protected array $genericProperties = ["name", "description", "special_features", "limitations", "price", "img_url"];

    public function __construct()
    {
        $pathChunks = $this->getPathChunks();
        $lastChunk = end($pathChunks);
        if(count($pathChunks) > 1) {
            $this->category = $lastChunk;
        }
        
        if(isset($_GET["category"])) {
            $this->category = $_GET["category"];
        }    

        $this->model = getModelNameFromCategoryName($this->category);
    }

    /**
     * Instantiate a product from its specific class
     * 
     * @access private
     * @package PhpTraining2\controllers
     * @param object $result i.e. a result (row) of a find() query
     * @return object
     */

     protected function getProductObject(object $result): object {
        $category = new ProductCategory($this->category);
        $specificProperties = $category->getSpecificProperties();
        $specificData = array_filter((array) $result, fn($key) => in_array($key, $specificProperties), ARRAY_FILTER_USE_KEY);

        $product = new ($this->model)(
            [
                "id" => $result->id,
                "category" => $this->category,
                "img_url" => $result->img_url,
                "name" => $result->name, 
                "description" => $result->description, 
                "special_features" => $result->special_features,
                "limitations" => $result->limitations,
                "price" => $result->price, 
            ],
            $specificData
        );
        return $product;
    }

    /**
     * Remove a product
     * 
     * @access public
     * @package PhpTraining2/controllers
     */

    public function remove(): void {
        $id = strip_tags($_GET["id"]);
        $this->table = $this->category;
        $this->delete("product_id", $id);

        // $this->showProductsOfCategory();
    }
}
