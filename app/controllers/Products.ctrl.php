<?php

namespace PhpTraining2\controllers;

use PhpTraining2\core\Controller;
use PhpTraining2\core\Model;

require_once MODELS_DIR . "Shoe.php";
require_once MODELS_DIR . "Equipment.php";

class Products {

    use Controller;
    use Model;

    private string $productCategory;
    private string $model;
    private array $specificProperties;

    public function __construct()
    {
        $this->productCategory = strip_tags($_GET["category"] ?? "");
        $this->model = "PhpTraining2\\models\\" . ucfirst($this->productCategory);
        
        switch ($this->productCategory) {
            case 'shoe':
                $this->specificProperties = ["waterproof", "level"];
                break;
            case 'equipment':
                $this->specificProperties = ["activity"];
                break;
            default:
                $this->specificProperties = [];
                break;
        }
    }

    /**
     * Default method of the controller
     * 
     * @access public
     * @package PhpTraining2\controllers
     */

    public function index(): void {
        if($this->productCategory === "") {
            $this->showCategories();
        } else {
            $table = $this->productCategory . "s";
            $designator = substr($this->productCategory, 0, 1);
            $this->table = "
                products p JOIN $table $designator
                WHERE p.id = $designator.product_id
            ";
            $content = $this->getPageContent();
            $this->view("pages/products", $content);
        }
    }

    /**
     * Show products categories if no category is specified
     * 
     * @access private
     * @package PhpTraining2\controllers
     */

    private function showCategories(): void {
        $this->view("pages/products");
    }


    /**
      * Get the values of the specific properties of this product category
      * 
      * @access private
      * @package PhpTraining2\controllers
      * @return array
      */

      private function getSpecificValues(): array {
        $specificValues = array_map(function($property) {
            if($property === "waterproof") {
                return strip_tags($_POST["waterproof"]) === "yes" ? 1 : 0;
            } else return strip_tags($_POST[$property]);
        }, $this->specificProperties);

        return $specificValues;
     }



    /**
     * Instantiate the Product class
     * 
     * @access private
     * @package PhpTraining2\controllers
     * @param object $data i.e. a result (row) of a find() query
     * @return object
     */

    private function instantiateProduct(object $data): object {
        $specific = array_map(
            fn(string $specificProperty): mixed => $data->$specificProperty, 
            $this->specificProperties
        );

        $product = new ($this->model)(
            $data->id,
            $this->productCategory,
            $data->name, 
            $data->description, 
            $data->price, 
            $data->img_url, // beware of difference between SQL column name (img_url) and php variable (imgUrl)
            ...$specific
        );

        return $product;
    }


    /**
     * Get the products page's html content
     * 
     * @access private
     * @package PhpTraining2\controllers
     * @return array
     */

     private function getPageContent(): array {
        $specific = implode(",", $this->specificProperties);
        $this->columns = "p.id as id, name, description, price, img_url, $specific";
        $results = $this->find();

        $content = [];

        if(!$results) {
            $content = [
                "<p>No product found.</p>"
            ];
        } else {
            foreach($results as $result) {
                $product = $this->instantiateProduct($result);
                $specificHtml = $product->getProductCardSpecificHtml();
                
                array_push($content, $product->getProductCardHtml($specificHtml));
            }
        }

        return $content;
     }

  

    /**
     * Control the "Add a product" form page. 
     * 
     * @access public
     * @package PhpTraining2\controllers
     */

    public function add(): void {

        if(isset($_POST["submit"])) {
            
            $required = ["name", "description", "price", ...$this->specificProperties];
            
            if($this->hasEmptyFields($required)) {
                $errorMessage = "Empty fields.";
                $this->view("pages/product-add", [], $errorMessage, null);
            } else {
                $id = 0;
                $category = $this->productCategory;
                $name = strip_tags($_POST["name"]);
                $description = strip_tags($_POST["description"]);
                $price = intval($_POST["price"]);
                $imgUrl = "";

                $specificValues = $this->getSpecificValues();
                $specificData = array_combine($this->specificProperties, $specificValues);
                
                $product = new ($this->model)($id, $category, $name, $description, $price, $imgUrl, ...$specificValues);
                $product->createSpecificProduct($specificData);

                $successMessage = "Product added.";
                $this->view("pages/product-add", [], null, $successMessage);
            }
        }

        $this->view("pages/product-add", [], null, null);
    }

    /**
     * Removes a product
     * 
     * @access public
     * @package PhpTraining2/controllers
     */

    public function remove(): void {
        $id = strip_tags($_GET["id"]);
        $this->table = $this->productCategory . "s";
        $this->delete("product_id", $id);

        $this->index();
    }
}