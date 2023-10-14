<?php

namespace PhpTraining2\models\forms;

use PhpTraining2\exceptions\FormEmailException;
use PhpTraining2\exceptions\FormEmptyFieldException;
use PhpTraining2\exceptions\FormNumberException;
use PhpTraining2\exceptions\FormPasswordLengthException;

abstract class Form implements FormInterface {

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
     * Add an item to the validation errors array
     * 
     * @access public
     * @package PhpTraining2\models
     */
    
     public function setValidationError(string $errorType, string $message): void {
        $this->validationErrors[$errorType] = $message;
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
     * Set form data in $_SESSION
     * 
     * @access public
     * @package PhpTraining2\models
     * @return array
     */

    public function setFormDataInSession(array $propertiesToValidate): array {
        $dataToStore = array_merge(
            ...array_map(fn($property) => [$property => $_POST[$property]], 
            $propertiesToValidate)
        );
        $_SESSION["formData"] = $dataToStore;
        return $dataToStore;
    }

    /**
     * Set an error message all the required fields have not been filled
     * 
     * @access public
     * @package PhpTraining2/models
     */

    public function setEmptyFieldsError(): void {
        if($this->hasEmptyFields()) {
            throw new FormEmptyFieldException();
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
                    if(!$validated) throw new FormEmailException();
                    break;
                case "password":
                    $validated = strlen($sanitizedInput["value"]) > 8; // TODO : dynamic min length
                    if(!$validated) throw new FormPasswordLengthException(8); // TODO : dynamic min length
                    break;
                case "number":
                    $validated = filter_var($sanitizedInput["value"], FILTER_VALIDATE_INT);
                    if(!$validated) throw new FormNumberException();
                    break;
                default:
                    $validated = $sanitizedInput;
                    break;
            }
        }
        // if(!$validated) $this->addValidationError($input["name"]);
        return $validated ? $sanitizedInput["value"] : false;
    }


    /**
     * Sanitize an input
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
                // $sanitized = filter_var($input["value"], FILTER_SANITIZE_EMAIL); // TODO with regex
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
}