<?php 

namespace PhpTraining2\controllers;

use PhpTraining2\controllers\ProductsController;
use PhpTraining2\models\ProductCategory;

require_once CTRL_DIR . "ProductsController.php";
require_once MODELS_DIR . "ProductCategory.php";
require_once MODELS_DIR . "products/Book.php";
require_once MODELS_DIR . "products/Protection.php";
require_once MODELS_DIR . "products/Shoe.php";
require_once MODELS_DIR . "products/Vehicle.php";
require_once MODELS_DIR . "products/Weapon.php";

class ProductCategoryController extends ProductsController {

    private object $productCategoryObject;
    
    public function __construct()
    {
        parent::__construct();
        
        if(!empty($this->category)) {
            $this->productCategoryObject = new ProductCategory($this->category);
        }
    }

    public function index():void {
        $pathChunks = $this->getPathChunks();
        
        if(count($pathChunks) === 1) {
            $this->showCategories();
            return;
        }
        
        $this->showProductsOfCategory();
    }

    /**
     * Show product categories if no category is specified
     * 
     * @access private
     * @package PhpTraining2\controllers
     */

     private function showCategories(): void {
        $productCategoryFiles = array_slice(scandir("assets/images/categories"), 2);
        $productCategories = array_map(fn($file) => str_replace(".webp", "", $file), $productCategoryFiles);
        $data = [];
        $data = array_map(function($category) {
            $categoryObject = new ProductCategory($category);
            $categoryData = [
                "name" => $category,
                "thumbnailURL" => $categoryObject->getThumbnailURL()
            ];
            return $categoryData;
        }, $productCategories);

        $this->view("pages/categories", $data);
    }

    /**
     * Show all the products of a specific category
     * 
     * @access private
     * @package PhpTraining2\controllers
     */

     private function showProductsOfCategory(): void {
        $products = $this->productCategoryObject->getProductsOfCategory();
        $pageContent = $this->getPageContent($products);

        $this->view("pages/category", $pageContent);
    }


    /**
     * Get the html content of a products' array
     * 
     * @access public
     * @package PhpTraining2\models
     * @param array $results
     * @return array
     */

     public function getPageContent(array $results): array {

        $content = [];

        if(!$results) {
            $content = [
                "<p>No product found.</p>"
            ];
        } else {
            foreach($results as $result) {
                $product = $this->getProductObject($result);                
                array_push($content, $product->getProductCardHtml());
            }
        }
        return $content;
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
        $specificProperties = $this->productCategoryObject->getSpecificProperties();
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
}