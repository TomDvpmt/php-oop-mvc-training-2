<?php 

namespace PhpTraining2\controllers;

use Exception;
use PhpTraining2\core\ControllerInterface;
use PhpTraining2\exceptions\FormEmptyFieldException;
use PhpTraining2\exceptions\ProductCreateException;
use PhpTraining2\exceptions\ProductGetDataException;
use PhpTraining2\models\forms\ProductFormAdd;
use PhpTraining2\models\Thumbnail;
use RuntimeException;

class ProductController extends ProductsController implements ControllerInterface {
    
    public function __construct()
    {
        parent::__construct();
    }

    public function index(): void {
        try {
            $data = $this->getFullData();
        } catch (ProductGetDataException $e) {
            $data = ["error" => "Unable to get product data."];
        }
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
        $product = new $this->model;
        $productData = $product->getProductDataFromDB();
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
            $product = new $this->model;
            $specificProperties = array_keys($product::DEFAULT_SPECIFIC_DATA);
            
            $form = new ProductFormAdd();
            $form->setRequired(array_merge($product::REQUIRED_GENERIC_PROPERTIES, $specificProperties));
            
            /* Check for empty required inputs */
            try {
                $form->setEmptyFieldsError();
            } catch (FormEmptyFieldException $e) {
                $this->view("pages/product-add", ["error" => $e->getMessage(), "specificAddFormHtml" => $specificAddFormHtml]);
                return;
            }

            /* Validate form inputs */
            try {
                $validatedData = $form->validateProductForm($product);
            } catch (RuntimeException $e) {
                $this->view("pages/product-add", ["error" => $e->getMessage(), "specificAddFormHtml" => $specificAddFormHtml]);
                return;
            }
            
            /* Thumbnail upload check */
            try {
                $upload = $this->getUploadedThumbnail();
            } catch (RuntimeException $e) {
                $this->view("pages/product-add", ["error" => $e->getMessage(), "specificAddFormHtml" => $specificAddFormHtml]);
                return;
            }
            
            /* Create the product */
            $validatedData["generic"]["thumbnail"] = $upload["thumbnail"] ?? $product::DEFAULT_THUMBNAIL;
            $formatedGenericData = $this->getFormatedGenericData($validatedData);
            $product->setGenericData($formatedGenericData);
            
            try {
                $product->createProduct($validatedData["specific"]);
            } catch (ProductCreateException $e) {
                echo $e->getMessage(); // TODO
                return;
            }

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
        $selectOptions = (new $this->model)->getSelectOptions();
        $html = [];
        foreach ($selectOptions["questions"] as $key => $value) {
            $question = $value;
            $options = [];
            $options[] = "<option value=''>--</option>";
            $answers = $selectOptions["answers"][$key];
            foreach ($answers as $answer) {
                $optionLabel = ucfirst($answer);
                $selected = isset($_POST["submit"]) && $_POST[$key] === $answer ? "selected" : null;
                $options[] = "<option value='$answer' $selected>$optionLabel</option>";
            }
            $optionsHtml = implode("", $options);
            $formFieldHtml= "
                <div class='form__field'>
                    <label for='$key'>* $question</label>
                    <select name='$key' id='$key'>$optionsHtml</select>
                </div>    
            ";
            $html[] = $formFieldHtml;
        }
        return implode("", $html);
    }

    /**
     * Get uploaded thumbnail file name
     * 
     * @access private
     * @package PhpTraining2\controllers
     * @return array
     */

    private function getUploadedThumbnail(): array|bool {
        if(!file_exists($_FILES['thumbnail']['tmp_name']) || !is_uploaded_file($_FILES['thumbnail']['tmp_name'])) {
            return false;
        }
        $thumb = new Thumbnail();
        $uploaded = $thumb->upload();
        return $uploaded;
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
        $product = new $this->model;
        try {
            $product->deleteThumbnailFile();
            $product->removeProductFromDB(); 
            header("Location:" . $this->category);
        } catch (Exception) {
            $this->view("pages/error500", ["error" => "Unable to delete the product."]);
        }
    }
};