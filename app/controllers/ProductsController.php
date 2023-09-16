<?php

namespace PhpTraining2\controllers;

use PhpTraining2\core\Controller;
use PhpTraining2\core\Model;
use PhpTraining2\models\Form;

require_once MODELS_DIR . "Shoe.php";
require_once MODELS_DIR . "Equipment.php";
require_once MODELS_DIR . "Form.php";

class ProductsController {

    use Controller;
    use Model;

    private string $category;
    private string $model;
    private array $genericProperties = ["name", "description", "price", "img_url"];
    private array $specificProperties = [];

    public function __construct()
    {
        $this->category = strip_tags($_GET["category"] ?? "");
        $this->model = "PhpTraining2\\models\\" . ucfirst($this->category);
        
        switch ($this->category) {
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
        $this->category === "" ? $this->showCategories() : $this->showProductsOfCategory();
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
     * Show all the products of a specific category
     * 
     * @access private
     * @package PhpTraining2\controllers
     */

    private function showProductsOfCategory(): void {
        $table = $this->category . "s";
        $designator = substr($this->category, 0, 1);
        $this->table = "
            products p JOIN $table $designator
            WHERE p.id = $designator.product_id
        ";
        $content = $this->getPageContent();
        $this->view("pages/products", $content);
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
     * Instantiate the Product class
     * 
     * @access private
     * @package PhpTraining2\controllers
     * @param object $data i.e. a result (row) of a find() query
     * @return object
     */

    private function instantiateProduct(object $data): object {
        $specificData = array_filter((array) $data, fn($key) => in_array($key, $this->specificProperties), ARRAY_FILTER_USE_KEY);

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
            
            $form = new Form();
            $form->setRequired(array_merge($this->genericProperties, $this->specificProperties));
            $_POST["img_url"] = "test.jpg"; // TODO : file upload
            
            if($form->hasEmptyFields()) {
                $form->setEmptyFieldsError();
                // show form with already filled values and error message
            } else {
                $genericToValidate = [
                    "name" => ["type" => "text", "value" => $_POST["name"], "name" => "name"],
                    "description" => ["type" => "text", "value" => $_POST["description"], "name" => "description"],
                    "price" => ["type" => "number", "value" => $_POST["price"], "name" => "price"],
                ];
                $genericValidated = $form->validate($genericToValidate);
                
                $specificToValidate = $form->getSpecificData($this->specificProperties);
                $specificValidated = $form->validate($specificToValidate);
                if(in_array("waterproof", array_keys($specificValidated))) {
                    $specificValidated["waterproof"] = $specificValidated["waterproof"] === "yes" ? 1 : 0;
                }
                
                if(!$genericValidated || !$specificValidated) {
                    show("There are errors !"); 
                    // TODO : deal with errors
                }
                
                $genericData = [
                    "id" => 0,
                    "category" => $this->category,
                    "img_url" => "test.jpg",
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
     * Removes a product
     * 
     * @access public
     * @package PhpTraining2/controllers
     */

    public function remove(): void {
        $id = strip_tags($_GET["id"]);
        $this->table = $this->category . "s";
        $this->delete("product_id", $id);

        $this->index();
    }
}