<?php

namespace PhpTraining2\models;

abstract class Form {

    /**
     * The fields that need to be validated in the signup form.
     */
    const REGISTER_TO_VALIDATE = ["firstName", "lastName", "email"];

    /**
     * The required fields in the signup form. 
     */
    const REGISTER_REQUIRED = ["email", "password", "passwordConfirm"];

    public function __construct(
        protected array $inputsToValidate = [], 
        protected array $required = [], 
        protected array $validationErrors = []
        )
    {}

    
    /**
     * Get an array of form validation errors
     * 
     * @access public
     * @package PhpTraining2\models
     * @return array
     */
    
    public function getValidationErrors(): array {
        return $this->validationErrors;
    }


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
     * Set from data in $_SESSION
     * 
     * @access public
     * @package PhpTraining2\models
     * @return array
     */

    public function setFormDataInSession(): array {
        $dataToStore = array_merge(...array_map(fn($property) => [$property => $_POST[$property]], $this::REGISTER_TO_VALIDATE));
        $_SESSION["formData"] = $dataToStore;
        return $dataToStore;
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
        $specificValues = array_map(fn($property) => [
            "type" => "text", 
            "name" => $property, 
            "value" => $_POST[$property]
        ], $specificProperties);
    
        return $specificValues;
    }

    /**
     * Set an error message all the required fields have not been filled
     * 
     * @access public
     * @package PhpTraining2/models
     */

    public function setEmptyFieldsError(): void {
        if($this->hasEmptyFields()) {
            $this->addValidationError("hasEmptyFields");
        }
    }


    /**
     * Check if a form has empty required fields
     * 
     * @access public
     * @package PhpTraining2/models
     * @return bool
     */

     public function hasEmptyFields() {
        $hasEmptyFields = array_reduce($this->required, function($acc, $item){ 
            return $acc || empty($_POST[$item]);
        }, false );
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
                // $sanitized = filter_var($input["value"], FILTER_SANITIZE_EMAIL);
                $sanitized = $input["value"];
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
            case "password":
                $sanitized = $input["value"];
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
     * @param string $name Error name: hasEmptyFields, emailInvalid, emailAlreadyUsed, password, price, passwordsDontMatch
     */

    public function addValidationError(string $name): void {
        switch ($name) {
            
            case "hasEmptyFields":
                $this->validationErrors["hasEmptyFields"] = "All required fields must be filled.";
                break;
            
            // /* user */
            // case 'emailInvalid':
            //     $this->validationErrors["emailInvalid"] = "Invalid email.";
            //     break;
            // case 'emailAlreadyUsed':
            //     $this->validationErrors["emailAlreadyUsed"] = "This email address is already used, please choose another one.";
            //     break;
            // case "password":
            //     $this->validationErrors["password"] = "Password must be at least 8 characters long.";
            //     break;
            // case "passwordsDontMatch": 
            //     $this->validationErrors["passwordsDontMatch"] = "Passwords don't match.";
            
            // /* product */
            // case "price":
            //     $this->validationErrors["price"] = "The price must be a number.";
            //     break;
            
            default:
                break;
        }
    }
}