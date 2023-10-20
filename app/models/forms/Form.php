<?php

namespace PhpTraining2\models\forms;

use PhpTraining2\exceptions\FormEmailException;
use PhpTraining2\exceptions\FormEmptyFieldException;
use PhpTraining2\exceptions\FormNumberException;
use PhpTraining2\exceptions\FormPasswordLengthException;
use SebastianBergmann\Type\MixedType;

abstract class Form implements FormInterface {

    public function __construct(
        protected array $inputsToValidate = [], 
        protected array $required = [], 
        protected array $validationErrors = []
        )
    {}


    // /**
    //  * Add an item to the validation errors array
    //  * 
    //  * @access public
    //  * @package PhpTraining2\models
    //  */
    
    //  public function setValidationError(string $errorType, string $message): void { // TODO : remove if unused
    //     $this->validationErrors[$errorType] = $message;
    // }


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
     * Throw an exception if all the required fields have not been filled
     * 
     * @access public
     * @package PhpTraining2/models
     */

    public function checkEmptyFields(): void {
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
     * Sanitize an input
     * 
     * @access public
     * @package PhpTraining2\models
     * @param array $input
     * @param string $name The input's type : email, text
     * @return mixed The input if sanitized, false otherwise
     */

    public function sanitizeInput(array $input): mixed {
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
                $sanitized = $input["value"]; // TODO
                break;
            default:
                $sanitized = null;
                break;
        }
        return [...$input, "value" => $sanitized];
    }
}