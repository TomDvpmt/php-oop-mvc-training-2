<?php

namespace PhpTraining2\models\forms;

use PhpTraining2\exceptions\FormEmailFormatException;
use PhpTraining2\exceptions\FormPasswordLengthException;
use PhpTraining2\models\forms\Form;

abstract class UserForm extends Form {

    public const PASSWORD_MIN_LENGTH = 8;
    
    public function __construct()
    {
        parent::__construct();
    }

    // TODO : DRY (same on ProductForm)
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


    // TODO : DRY (same on ProductForm)
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
            switch($sanitizedInput["name"]) {
                case "email":
                    $validated = $this->validateEmail($sanitizedInput);
                    break;
                case "password":
                    $validated = $this->validatePassword($sanitizedInput);
                    break;
                default:
                    $validated = $sanitizedInput;
                    break;
            }
        }
        return $validated ? $sanitizedInput["value"] : false;
    }

    /**
     * Validate email input
     * 
     * @access private
     * @package PhpTraining2\models\forms
     * @return bool
     */

    private function validateEmail(array $sanitizedInput): bool {
        $validated = filter_var($sanitizedInput["value"], FILTER_VALIDATE_EMAIL);
        if(!$validated) throw new FormEmailFormatException();
        return $validated;
    }

    /**
     * Validate password input
     * 
     * @access private
     * @package PhpTraining2\models\forms
     * @return bool
     */

    private function validatePassword(array $sanitizedInput): bool {
        $validated = strlen($sanitizedInput["value"]) >= self::PASSWORD_MIN_LENGTH;
        if(!$validated) throw new FormPasswordLengthException(self::PASSWORD_MIN_LENGTH);
        return $validated;
    }

    /**
     * Add an item to the form errors array
     * 
     * @access public
     * @package PhpTraining2\models\forms
     * @param string $name Error name: emailInvalid, emailAlreadyUsed, password, passwordsDontMatch
     */

     public function addValidationError(string $name): void {
        switch ($name) {
            case "hasEmptyFields":
                $this->setValidationError("hasEmptyFields", "All required fields must be filled.");
                break;
            case 'emailInvalid':
                $this->setValidationError("emailInvalid", "Invalid email.");
                break;
            case 'emailAlreadyUsed':
                $this->setValidationError("emailAlreadyUsed", "This email address is already used, please choose another one.");
                break;
            case "password":
                $this->setValidationError("password", "Password must be at least 8 characters long."); // TODO : dynamic min length
                break;
            case "passwordsDontMatch": 
                $this->setValidationError("passwordsDontMatch", "Passwords don't match.");
            default:
                break;
        }
    }
}