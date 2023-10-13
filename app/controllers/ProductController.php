<?php 

namespace PhpTraining2\controllers;

use PhpTraining2\controllers\ControllerInterface;
use PhpTraining2\models\forms\ProductForm;
use PhpTraining2\models\Thumbnail;

class ProductController extends ProductsController implements ControllerInterface {
    
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

            $model = "PhpTraining2\models\products\\" . $this->model;
            $product = new $model;
            $specificProperties = array_keys($product::DEFAULT_SPECIFIC_DATA);
            
            /* Form validation */
            $form = new ProductForm();
            $form->setRequired(array_merge($product::REQUIRED_GENERIC_PROPERTIES, $specificProperties));
            
            if($form->hasEmptyFields()) {
                show("empty fields");
                $form->setEmptyFieldsError();
                // TODO : show form with already filled values and error message
                return;
            }  

            $validatedData = $form->validateProductForm($product);
            if(!$validatedData) {
                show("There are errors!"); // TODO : deal with errors
                return;
                // $this->showFormWithErrors($form, "products/add");
            }
            
            /* Thumbnail upload check */
            $thumbnail = $this->getUploadedThumbnail();
            $validatedData["generic"]["thumbnail"] = $thumbnail ?? $product::DEFAULT_THUMBNAIL;
            
            /* Creating the product */
            $formatedGenericData = $this->getFormatedGenericData($validatedData);
            $product->setGenericData($formatedGenericData);
            $product->createSpecificProduct($validatedData["specific"]);

            $successMessage = "Product added."; // TODO : show success message in destination page           
            header("Location: " . ROOT . "products/" . $this->category);
            

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
     * Get uploaded thumbnail file name
     * 
     * @access private
     * @package PhpTraining2\controllers
     * @return string|bool
     */

    private function getUploadedThumbnail(): string|bool {
        if(!file_exists($_FILES['thumbnail']['tmp_name']) || !is_uploaded_file($_FILES['thumbnail']['tmp_name'])) {
            return false;
        }
        $thumb = new Thumbnail();
        $upload = $thumb->upload();
        return $upload["thumbnail"];
    }


    /**
     * Get formated generic data for creating product
     * 
     * @access private
     * @package PhpTraining2\controllers
     */

    private function getFormatedGenericData(array $validatedData): array {
        $formatedData = [
            "id" => 0,
            "category" => $this->category,
            "thumbnail" => $validatedData["generic"]["thumbnail"],
            "name" => ucfirst($validatedData["generic"]["name"]),
            "description" => ucfirst($validatedData["generic"]["description"]),
            "special_features" => $validatedData["generic"]["special_features"],
            "limitations" => $validatedData["generic"]["limitations"],
            "price" => $validatedData["generic"]["price"],
        ];
        return $formatedData;
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