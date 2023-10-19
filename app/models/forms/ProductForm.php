<?php

namespace PhpTraining2\models\forms;

use PhpTraining2\exceptions\FormNumberException;
use PhpTraining2\models\forms\Form;

abstract class ProductForm extends Form {
    

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Validate a product form
     * 
     * @access public
     * @package PhpTraining2\models\forms
     * @param object $product
     * @return array|bool
     */

    public function validateProductForm(object $product): array|bool {
        $genericToValidate = $this->getGenericInputsToValidate($product::GENERIC_PROPERTIES);                
        $genericValidated = $this->validate($genericToValidate);
        $specificToValidate = $this->getSpecificData(array_keys($product::DEFAULT_SPECIFIC_DATA));
        $specificValidated = $this->validate($specificToValidate);
        
        if(!$genericValidated || !$specificValidated) {
            return false;
        }
        $validatedData = ["generic" => $genericValidated, "specific" => $specificValidated];
        return $validatedData;
    }

    // TODO : DRY (same on UserForm)
    /**
     * Validate an array of inputs
     * 
     * @access public
     * @package PhpTraining2\models
     * @param array $inputs
     * @return mixed The sanitized and validated array if no errors, false if errors
     */

     public function validate(array $inputs): mixed {
        $tested = array_map(function($input) {
            $sanitizedInput = $this->sanitizeInput($input);
            return $this->validateInput($sanitizedInput);
        }, $inputs);
        return empty($this->validationErrors) ? $tested : false;
    }


    // TODO : DRY (same on UserForm)
    /**
     * Validate user input
     * 
     * @access private
     * @package PhpTraining2\models\forms
     * @param array $input [string $type, mixed $value, string $name]
     * @return mixed The input if validated, false otherwise
     */

     private function validateInput(array $sanitizedInput): mixed {
        $validated = false;
        if(isset($sanitizedInput["value"])) {
            switch($sanitizedInput["type"]) {
                case "number":
                    $validated = filter_var($sanitizedInput["value"], FILTER_VALIDATE_INT);
                    if(!$validated) throw new FormNumberException();
                    break;
                default:
                    $validated = $sanitizedInput;
                    break;
            }
        }
        return $validated ? $sanitizedInput["value"] : false;
    }


    /**
     * Get generic inputs to validate
     * 
     * @access private
     * @package PhpTraining2\controllers
     * @return array
     */

     private function getGenericInputsToValidate($genericProperties): array {
        $genericToValidate = [];
        foreach ($genericProperties as $key => $value) {
            $genericToValidate[$key] = ["type" => $value, "value" => $_POST[$key], "name" => $key];
        }
        return $genericToValidate;
    }


    /**
     * Get specific data for this product category
     * 
     * @access private
     * @package PhpTraining2\models\forms
     * @param array $specificProperties Array of strings (the list of specific properties for this product category)
     * @return array
     */

     private function getSpecificData(array $specificProperties): array {
        $specificValues = $this->getSpecificValues($specificProperties);
        return array_combine($specificProperties, $specificValues);
    }

    /**
     * Get the values of the specific properties of this product category
    * 
    * @access private
    * @package PhpTraining2\models\forms
    * @param array $specificProperties Array of strings (the list of specific properties for this product category)
    * @return array
    */

    private function getSpecificValues(array $specificProperties): array {
        $specificValues = array_map(fn($property) => [
            "type" => "text", 
            "name" => $property, 
            "value" => $_POST[$property]
        ], $specificProperties);
    
        return $specificValues;
    }

    // /**
    //  * Add an item to the form errors array
    //  * 
    //  * @access public
    //  * @package PhpTraining2\models\forms
    //  * @param string $name Error name: hasEmptyFields, price
    //  */

    //  public function addValidationError(string $name): void {
    //     switch ($name) {
    //         case "hasEmptyFields":
    //             $this->setValidationError("hasEmptyFields", "All required fields must be filled.");
    //             break;

    //         case "price":
    //             $this->setValidationError("price", "The price must be a number.");
    //             break;
            
    //         default:
    //             break;
    //     }
    // }
}