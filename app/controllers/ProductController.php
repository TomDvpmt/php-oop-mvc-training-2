<?php 

namespace PhpTraining2\controllers;

use PhpTraining2\models\Form;
use PhpTraining2\models\ProductCategory;

require_once CTRL_DIR . "ProductsController.php";

require_once MODELS_DIR . "Form.php";
require_once MODELS_DIR . "Product.php";
require_once MODELS_DIR . "ProductCategory.php";
require_once MODELS_DIR . "products/Book.php";
require_once MODELS_DIR . "products/Protection.php";
require_once MODELS_DIR . "products/Shoe.php";
require_once MODELS_DIR . "products/Vehicle.php";
require_once MODELS_DIR . "products/Weapon.php";

class ProductController extends ProductsController {

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Default method of the controller
     * 
     * @access public
     * @package PhpTraining2\controllers
     * 
     */

    public function index(): void {
        $data = $this->getFullData();
        $this->view("pages/product", $data);
    }

    

    /**
     * Get full product data
     * 
     * Includes questions and answers from select options
     * 
     * @access private
     * @package PhpTraining2\controllers
     * @return array [array $genericData, array $specificData]
     */

    private function getFullData(): array {
        $model = getModelNameFromCategoryName($this->category);
        $product = new $model();
        $productData = $product->getProductData();
        $specific = [];
        foreach ($productData["specificData"] as $key => $value) {
            $question = $product->getSelectOptions()["questions"][$key];
            $specific[$key] = ["question" => $question, "answer" => $value];
        }
        return [...$productData, "specificData" => $specific];
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

            $category = new ProductCategory($this->category);
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

    /**
     * Get specific html for the add product form
     * 
     * @access private
     * @package PhpTraining2\controllers
     * @return string
     */

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
};