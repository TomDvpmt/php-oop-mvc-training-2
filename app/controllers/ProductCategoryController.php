<?php 

namespace PhpTraining2\controllers;

use Exception;
use LogicException;
use PhpTraining2\controllers\ControllerInterface;
use PhpTraining2\models\products\ProductCategory;
use PhpTraining2\models\products\Product;

class ProductCategoryController extends ProductsController implements ControllerInterface {

    private ProductCategory $productCategoryObject;
    
    public function __construct()
    {
        parent::__construct();
        
        if(!empty($this->category)) {
            $this->productCategoryObject = new ProductCategory($this->category);
        }
    }

    public function index(): void {
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
        $data = [];
        try {
            $scanned = scandir(ProductCategory::PRODUCT_CATEGORIES_THUMB_DIR);
            if(!$scanned) {
                throw new LogicException("Unable to display product categories.");
            }
            $productCategoryFiles = array_slice($scanned, 2);
            $productCategories = array_map(fn($file) => str_replace(".webp", "", $file), $productCategoryFiles);
            $data = array_map(function($category) {
                $categoryObject = new ProductCategory($category);
                $categoryData = [
                    "name" => $category,
                    "thumbnail" => $categoryObject->getThumbnail()
                ];
                return $categoryData;
            }, $productCategories);
        } catch (Exception $e) {
            $data = ["error" => $e->getMessage()];
        }
        $this->view("pages/categories", $data);
    }

    /**
     * Show all the products of a specific category
     * 
     * @access private
     * @package PhpTraining2\controllers
     */

     private function showProductsOfCategory(): void {
        try {
            $products = $this->productCategoryObject->getProductsOfCategory();
            $pageContent = $this->getPageContent($products);
            $this->view("pages/category", $pageContent);
        } catch (Exception $e) {
            $this->view("pages/category", ["error" => "Unable to display products."]);
        }
    }


    /**
     * Get the html content of a products' array
     * 
     * @access private
     * @package PhpTraining2\controllers
     * @param array $results
     * @return array
     */

     private function getPageContent(array $results): array {

        $content = [];

        if(!$results) {
            $content = [
                "<p>No product found.</p>"
            ];
        } else {
            foreach($results as $result) {
                $product = $this->getProductObject($result);
                $content[] = $product->getProductCardHtml();              
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
     * @return Product
     */

    private function getProductObject(object $result): Product {
        $product = new $this->model;
        $specificProperties = array_keys($product::DEFAULT_SPECIFIC_DATA);
        
        $specificData = array_filter(
            (array) $result, 
            fn($key) => in_array($key, $specificProperties), 
            ARRAY_FILTER_USE_KEY
        );

        $genericData = [
            "id" => $result->id,
            "category" => $this->category,
            "thumbnail" => $result->thumbnail,
            "name" => $result->name, 
            "description" => $result->description, 
            "special_features" => $result->special_features,
            "limitations" => $result->limitations,
            "price" => $result->price, 
        ];

        $product = new ($this->model)($genericData, $specificData);
        return $product;
    }
}