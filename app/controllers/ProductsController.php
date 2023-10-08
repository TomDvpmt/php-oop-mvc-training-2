<?php

namespace PhpTraining2\controllers;

use PhpTraining2\core\Controller;
use PhpTraining2\core\Model;
use PhpTraining2\models\Category;
use PhpTraining2\models\Form;

require_once MODELS_DIR . "products/Book.php";
require_once MODELS_DIR . "products/Protection.php";
require_once MODELS_DIR . "products/Shoe.php";
require_once MODELS_DIR . "products/Vehicle.php";
require_once MODELS_DIR . "products/Weapon.php";
require_once MODELS_DIR . "Category.php";
require_once MODELS_DIR . "Form.php";

class ProductsController {

    use Controller;
    use Model;

    private string $category = "";
    private string $model;
    private array $genericProperties = ["name", "description", "special_features", "limitations", "price", "img_url"];

    public function __construct()
    {
        $pathChunks = $this->getPathChunks();
        if(count($pathChunks) > 1) {
            $this->category = end($pathChunks);
        }
        
        if(isset($_GET["category"])) {
            $this->category = $_GET["category"];
        }        

        $this->model = getModelNameFromCategoryName($this->category);
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
                "special_features" => $data->special_features,
                "limitations" => $data->limitations,
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
        $specificAddFormHtml = null;

        if(isset($_GET["category"])) {
            $specificAddFormHtml = $this->getSpecificAddFormHtml();
        }

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
                    "special_features" => ["type" => "text", "value" => $_POST["special_features"], "name" => "special_features"],
                    "limitations" => ["type" => "text", "value" => $_POST["limitations"], "name" => "limitations"],
                    "price" => ["type" => "number", "value" => $_POST["price"], "name" => "price"],
                ];
                $genericValidated = $form->validate($genericToValidate);

                
                $specificToValidate = $form->getSpecificData($specificProperties);
                $specificValidated = $form->validate($specificToValidate);
                
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
                    "special_features" => $genericValidated["special_features"],
                    "limitations" => $genericValidated["limitations"],
                    "price" => $genericValidated["price"],
                ];
    
                $product = new ($this->model)($genericData);
                $product->createSpecificProduct($specificValidated);
    
                $successMessage = "Product added.";
                $this->view("pages/product-add", [], null, $successMessage);
            }

        } else {
            $this->view("pages/product-add", ["specificAddFormHtml" => $specificAddFormHtml], null, null);
        }

    }

    private function getSpecificAddFormHtml(): string {
        $selectOptions = (new $this->model)->getSelectOptions();
        $html = [];
        foreach ($selectOptions["questions"] as $key => $value) {
            $options = [];
            $question = $value;
            array_push($options, "<option value=''>-- $question --</option>");
            $answers = $selectOptions["answers"][$key];
            foreach ($answers as $answer) {
                $label = ucfirst($answer);
                array_push($options, "<option value='$answer'>$label</option>");
            }
            $optionsHtml = implode("", $options);
            $formFieldHtml= "
                <div class='form__field'>
                    <select name='$key' id='$key'>$optionsHtml</select>
                </div>    
            ";
            array_push($html, $formFieldHtml);
        }
        return implode("", $html);
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
