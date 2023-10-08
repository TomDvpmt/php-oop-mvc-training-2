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
    
    public function __construct()
    {
        parent::__construct();
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
        $this->view("pages/categories");
    }

    /**
     * Show all the products of a specific category
     * 
     * @access private
     * @package PhpTraining2\controllers
     */

     private function showProductsOfCategory(): void {
        $category = new ProductCategory($this->category);
        $products = $category->getProductsOfCategory();
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
                $specificHtml = $product->getProductCardSpecificHtml();
                
                array_push($content, $product->getProductCardHtml($specificHtml));
            }
        }
        return $content;
     }
}