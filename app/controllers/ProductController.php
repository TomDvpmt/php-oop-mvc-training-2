<?php 

namespace PhpTraining2\controllers;

use PhpTraining2\controllers\ControllerInterface;
use PhpTraining2\models\ProductForm;
use PhpTraining2\models\ProductCategory;
use PhpTraining2\models\Thumbnail;

class ProductController extends ProductsController implements ControllerInterface {

    protected const GENERIC_PROPERTIES = [
        "name" => "text", 
        "description" => "text", 
        "special_features" => "text", 
        "limitations" => "text", 
        "price" => "number"
    ];
    protected const REQUIRED_GENERIC_PROPERTIES = ["name", "description", "price"];
    protected const DEFAULT_THUMBNAIL = "default_product_thumbnail.webp"; // TODO: put a default img in the default folder
    
    public function __construct()
    {
        parent::__construct();
    }

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
        $model = "PhpTraining2\models\products\\" . getModelNameFromCategoryName($this->category);
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
     * Control the "Add a product" Product page. 
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
            $thumbnail = self::DEFAULT_THUMBNAIL;

            $category = new ProductCategory($this->category);
            $specificProperties = $category->getSpecificProperties();
            
            $form = new ProductForm();
            $form->setRequired(array_merge(self::REQUIRED_GENERIC_PROPERTIES, $specificProperties));
                        
            if($form->hasEmptyFields()) {
                show("empty fields");
                $form->setEmptyFieldsError();
                // TODO : show form with already filled values and error message
            } else {                
                /* File upload handling */
                if(file_exists($_FILES['image-file']['tmp_name']) && is_uploaded_file($_FILES['image-file']['tmp_name'])) {
                    $thumb = new Thumbnail();
                    $upload = $thumb->upload();
                    if($upload["success"]) {
                        $thumbnail = $thumb->getSavedFileName();
                    } else {
                        show($upload["errors"]); // TODO
                        return;
                    }
                }

                /* Input data validation */
                
                $genericToValidate = $this->getGenericToValidate();                
                $genericValidated = $form->validate($genericToValidate);
                $specificToValidate = $form->getSpecificData($specificProperties);
                $specificValidated = $form->validate($specificToValidate);
                
                if(!$genericValidated || !$specificValidated) {
                    show("There are errors !"); 
                    // TODO : deal with errors
                    return;
                }
                
                /* Creating the product */
                $genericData = [
                    "id" => 0,
                    "category" => $this->category,
                    "thumbnail" => $thumbnail,
                    "name" => ucfirst($genericValidated["name"]),
                    "description" => ucfirst($genericValidated["description"]),
                    "special_features" => $genericValidated["special_features"],
                    "limitations" => $genericValidated["limitations"],
                    "price" => $genericValidated["price"],
                ];

                $model = "PhpTraining2\models\products\\" . $this->model;
    
                $product = new ($model)($genericData);
                $product->createSpecificProduct($specificValidated);
    
                $successMessage = "Product added."; // TODO : show success message in destination page           
                header("Location: " . ROOT . "products/" . $this->category);
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
        $model = "PhpTraining2\models\products\\" . $this->model;
        $selectOptions = (new $model)->getSelectOptions();
        $html = [];
        foreach ($selectOptions["questions"] as $key => $value) {
            $options = [];
            $question = $value;
            array_push($options, "<option value=''>--</option>");
            $answers = $selectOptions["answers"][$key];
            foreach ($answers as $answer) {
                $optionLabel = ucfirst($answer);
                array_push($options, "<option value='$answer'>$optionLabel</option>");
            }
            $optionsHtml = implode("", $options);
            $formFieldHtml= "
                <div class='form__field'>
                    <label for='$key'>* $question</label>
                    <select name='$key' id='$key'>$optionsHtml</select>
                </div>    
            ";
            array_push($html, $formFieldHtml);
        }
        return implode("", $html);
    }


    /**
     * Get generic data to validate
     * 
     * @access private
     * @package PhpTraining2\controllers
     * @return array
     */

    private function getGenericToValidate(): array {
        $genericToValidate = [];
        foreach (self::GENERIC_PROPERTIES as $key => $value) {
            $genericToValidate[$key] = ["type" => $value, "value" => $_POST[$key], "name" => $key];
        }
        return $genericToValidate;
    }


    /**
     * Remove a product
     * 
     * @access public
     * @package PhpTraining2/controllers
     */

     public function remove(): void {
        $model = "PhpTraining2\models\products\\" . $this->model;
        $product = new $model;
        $product->deleteThumbnailFile();
        $product->removeProductFromDB(); 
        header("Location:" . $this->category);
    }
};