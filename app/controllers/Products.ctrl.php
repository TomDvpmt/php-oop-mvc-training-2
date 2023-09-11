<?php

namespace PhpTraining2\controllers;

use PhpTraining2\core\Controller;
use PhpTraining2\core\Model;

require_once MODELS_DIR . "Shoe.php";
require_once MODELS_DIR . "Equipment.php";

class Products {

    use Controller;
    use Model;

    private string $productType;
    private string $model;
    private array $specificProperties;

    public function __construct()
    {
        $this->productType = strip_tags($_GET["type"] ?? "");
        $this->model = "PhpTraining2\\models\\" . ucfirst($this->productType);
        
        switch ($this->productType) {
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
     * Entry method of the controller (control each product's category main page). 
     * 
     * @access public
     * @package PhpTraining2\controllers
     */

    public function index() {
        $table = $this->productType . "s";
        $designator = substr($this->productType, 0, 1);
        $this->table = "
            products p JOIN $table $designator
            WHERE p.id = $designator.product_id
        ";
        $content = $this->getPageContent();
        $this->view("pages/$table", $content);
    }


    /**
     * Get the page's html content
     * 
     * @access private
     * @package PhpTraining2/controllers
     * @return array
     */

     private function getPageContent() {
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
                $specific = array_map(fn($item) => $result->$item, $this->specificProperties);

                $product = new ($this->model)(
                    $result->id,
                    $this->productType,
                    $result->name, 
                    $result->description, 
                    $result->price, 
                    $result->img_url, // beware of difference between SQL column name (img_url) and php variable (imgUrl)
                    ...$specific
                );
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

    public function add() {

        if(isset($_POST["submit"])) {
            
            $required = ["name", "description", "price", ...$this->specificProperties];
            
            if($this->hasEmptyFields($required)) {
                $errorMessage = "Empty fields.";
                $this->view("pages/product-add", [], $errorMessage, null);
            } else {
                $id = 0;
                $type = $this->productType;
                $name = strip_tags($_POST["name"]);
                $description = strip_tags($_POST["description"]);
                $price = intval($_POST["price"]);
                $imgUrl = "";

                $specificValues = array_map(function($property) {
                    if($property === "waterproof") {
                        return strip_tags($_POST["waterproof"]) === "yes" ? 1 : 0;
                    } else return strip_tags($_POST[$property]);
                }, $this->specificProperties);
                
                $product = new ($this->model)($id, $type, $name, $description, $price, $imgUrl, ...$specificValues);

                $specificData = array_combine($this->specificProperties, $specificValues);
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

    public function remove() {
        $id = strip_tags($_GET["id"]);
        $this->table = $this->productType . "s";
        $this->delete("product_id", $id);

        $this->index();
    }

    
    
}