<?php

namespace PhpTraining2\controllers;

use PhpTraining2\core\Controller;
use PhpTraining2\core\Model;
use PhpTraining2\models\Category;
use PhpTraining2\models\Form;

require_once MODELS_DIR . "Shoe.php";
require_once MODELS_DIR . "Equipment.php";
require_once MODELS_DIR . "Category.php";
require_once MODELS_DIR . "Form.php";

class ProductsController {

    use Controller;
    use Model;

    private string $category = "";
    private string $model;
    private array $genericProperties = ["name", "description", "price", "img_url"];

    public function __construct()
    {
        $pathChunks = $this->getPathChunks();
        if(count($pathChunks) > 1) {
            $this->category = end($pathChunks);
        }
        
        if(isset($_GET["category"])) {
            $this->category = $_GET["category"];
        }        

        // Remove the final "s" of the category name if it has one, to get the model name (shoes => Shoe)
        $category = $this->category;
        $model = substr($category, -1) === "s" ? substr($category, 0, -1) : $category;
        $this->model = "PhpTraining2\\models\\" . ucfirst($model);
    }

    /**
     * Default method of the controller
     * 
     * @access public
     * @package PhpTraining2\controllers
     */

    public function index(): void {
        $pathChunks = $this->getPathChunks();
        
        $method = $this->getMethod($pathChunks);
        if($method) $this->$method();
        
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
        $category = new Category($this->category);
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


     /**
     * Instantiate the product from its specific class
     * 
     * @access private
     * @package PhpTraining2\models
     * @param object $data i.e. a result (row) of a find() query
     * @return object
     */

    private function getProductObject(object $data): object {
        $category = new Category($this->category);
        $specificProperties = $category->getSpecificProperties();
        $specificData = array_filter((array) $data, fn($key) => in_array($key, $specificProperties), ARRAY_FILTER_USE_KEY);

        $product = new ($this->model)(
            [
                "id" => $data->id,
                "category" => $this->category,
                "img_url" => $data->img_url,
                "name" => $data->name, 
                "description" => $data->description, 
                "price" => $data->price, 
            ],
            $specificData
        );
        return $product;
    }
      

    /**
     * Control the "Add a product" form page. 
     * 
     * @access public
     * @package PhpTraining2\controllers
     */

    public function add(): void {

        if(isset($_POST["submit"])) {
            $category = new Category($this->category);
            $specificProperties = $category->getSpecificProperties();
            
            $form = new Form();
            $form->setRequired(array_merge($this->genericProperties, $specificProperties));
            $_POST["img_url"] = "test.jpg"; // TODO : file upload
            
            if($form->hasEmptyFields()) {
                $form->setEmptyFieldsError();
                // TODO : show form with already filled values and error message
            } else {
                $genericToValidate = [
                    "name" => ["type" => "text", "value" => $_POST["name"], "name" => "name"],
                    "description" => ["type" => "text", "value" => $_POST["description"], "name" => "description"],
                    "price" => ["type" => "number", "value" => $_POST["price"], "name" => "price"],
                ];
                $genericValidated = $form->validate($genericToValidate);
                
                $specificToValidate = $form->getSpecificData($specificProperties);
                $specificValidated = $form->validate($specificToValidate);
                if(in_array("waterproof", array_keys($specificValidated))) {
                    $specificValidated["waterproof"] = $specificValidated["waterproof"] === "yes" ? 1 : 0;
                }
                
                if(!$genericValidated || !$specificValidated) {
                    show("There are errors !"); 
                    // TODO : deal with errors
                    return;
                }
                
                $genericData = [
                    "id" => 0,
                    "category" => $this->category,
                    "img_url" => "",
                    "name" => $genericValidated["name"],
                    "description" => $genericValidated["description"],
                    "price" => $genericValidated["price"],
                ];
    
                $product = new ($this->model)($genericData);
                $product->createSpecificProduct($specificValidated);
    
                $successMessage = "Product added.";
                $this->view("pages/product-add", [], null, $successMessage);
            }

        } else {
            $this->view("pages/product-add", [], null, null);
        }

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

        $this->showProductsOfCategory();
    }
}
