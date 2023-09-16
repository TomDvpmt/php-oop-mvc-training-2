<?php

namespace PhpTraining2\models;

class Form {

    public function __construct(private array $inputs = [], private array $required = [], private array $validationErrors = [])
    {}

    /**
     * Set the required fields array
     * 
     * @access public
     * @package PhpTraining2\models
     * @param array $required Array of strings (field names)
     */

    public function setRequired(array $required) {
        $this->required = $required;
    }

    /**
     * Get specific data for this product category
     * 
     * @access public
     * @package PhpTraining2\models
     * @param array $specificProperties Array of strings (the list of specific properties for this product category)
     * @return array
     */

    public function getSpecificData(array $specificProperties): array {
        $specificValues = $this->getSpecificValues($specificProperties);
        return array_combine($specificProperties, $specificValues);
    }


    /**
     * Get the values of the specific properties of this product category
    * 
    * @access private
    * @package PhpTraining2\models
    * @param array $specificProperties Array of strings (the list of specific properties for this product category)
    * @return array
    */

    private function getSpecificValues(array $specificProperties): array {
        $specificValues = array_map(function($property) {
            switch ($property) {
                /* Shoe */
                case 'waterproof':
                    $data = ["type" => "text", "name" => "waterproof", "value" => $_POST["waterproof"]];
                    break;
                case 'level':
                    $data = ["type" => "text", "name" => "level", "value" => $_POST["level"]];
                    break;
                /* Equipement */
                case 'activity':
                    $data = ["type" => "text", "name" => "activity", "value" => $_POST["activity"]];
                    break;
                default:
                    $data = [];
                    break;
            }
            return $data;
            // if($property === "waterproof") {
            //     return $_POST["waterproof"] === "yes" ? 1 : 0;
            // } else return $_POST[$property];
        }, $specificProperties);
    
        return $specificValues;
    }



    /**
     * Check if a form has empty required fields
     * 
     * @access public
     * @package PhpTraining2/models
     * @return bool
     */

     public function hasEmptyFields() {
        $hasEmptyFields = array_reduce($this->required, fn($acc, $item) => $acc || empty($_POST[$item]), false );
        return $hasEmptyFields;
    }

    /**
     * Validate an array of inputs
     * 
     * @access public
     * @package PhpTraining2\models
     * @param array $inputs
     * @return mixed The sanitized and validated array if no errors, false if errors
     */

     public function validate(array $inputs): mixed {
        $tested = array_map(fn($input) => $this->validateInput($input), $inputs);
        return empty($this->validationErrors) ? $tested : false;
    }


    /**
     * Validate user input
     * 
     * @access private
     * @package PhpTraining2\models
     * @param array $input [string $type, mixed $value, string $name]
     * @return mixed The input if validated, false otherwise
     */

    private function validateInput(array $input) {
        $sanitizedInput = $this->sanitizeInput($input);
        $validated = false;
        if(isset($sanitizedInput["value"])) {
            switch($input["type"]) {
                case "email":
                    $validated = filter_var($sanitizedInput["value"], FILTER_VALIDATE_EMAIL);
                    break;
                case "password":
                    $validated = strlen($sanitizedInput["value"]) > 8;
                    break;
                case "number":
                    $validated = filter_var($sanitizedInput["value"], FILTER_VALIDATE_INT);
                    break;
                default:
                    $validated = $sanitizedInput;
                    break;
            }
        }
        if(!$validated) $this->addValidationError($input["name"]);
        return $validated ? $sanitizedInput["value"] : false;
    }


    /**
     * Sanitize a user input
     * 
     * @access private
     * @package PhpTraining2\models
     * @param array $input
     * @param string $name The input's type : email, text
     * @return mixed The input if sanitized, false otherwise
     */

    private function sanitizeInput(array $input): mixed {
        $sanitized = null;
        switch($input["type"]) {
            case "email":
                $sanitized = filter_var($input["value"], FILTER_SANITIZE_EMAIL);
                break;
            case "text":
                $sanitized = htmlspecialchars($input["value"], ENT_NOQUOTES);
                break;
            case "number":
                $sanitized = filter_var($input["value"], FILTER_SANITIZE_NUMBER_INT);
                break;
            case "url":
                $sanitized = filter_var($input["value"], FILTER_SANITIZE_URL);
                break;
            default:
                $sanitized = null;
                break;
        }
        return [...$input, "value" => $sanitized];
    }

    

    /**
     * Add an item to the form errors array
     * 
     * @access public
     * @package PhpTraining2\models
     * @param string $name Error name: hasEmptyFields, email, password, price
     */

    public function addValidationError(string $name): void {
        switch ($name) {
            case "hasEmptyFields":
                array_push($this->validationErrors, ["hasEmptyFields" => "All required fields must be filled."]);
                break;
            case 'email':
                array_push($this->validationErrors, ["email" => "Invalid email."]);
                break;
            case "password":
                array_push($this->validationErrors, ["password" => "Password must be at least 8 characters long."]);
                break;
            case "price":
                array_push($this->validationErrors, ["price" => "The price must be a number."]);
                break;
            default:
                break;
        }
    }
}