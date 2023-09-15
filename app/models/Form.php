<?php

namespace PhpTraining2\models;

class Form {

    public function __construct(private array $inputs = [], private array $validationErrors = [])
    {}


    /**
     * Check if a form has empty required fields
     * 
     * @access public
     * @package PhpTraining2/controllers
     * @param array $required The required fields
     * @return bool
     */

     public function hasEmptyFields(array $required) {
        $hasEmptyFields = array_reduce($required, fn($acc, $item) => $acc || empty($_POST[$item]), false );
        return $hasEmptyFields;
    }


    /**
     * Checks if the email input's format is valid.
     * 
     * @access public
     * @package PhpTraining2\core
     * @param string $email
     * @return bool
     */

     public function isEmailValid($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }


    /**
     * Sanitize a user input
     * 
     * @access public
     * @package PhpTraining2\core
     * @param string $input
     * @param string $name The input's name
     * @return mixed The input if sanitized, false otherwise
     */

    public function sanitizeInput(string $input, string $name): mixed {
        switch($name) {
            case "email":
                $sanitized = filter_var($input, FILTER_SANITIZE_EMAIL);
                break;
            case "firstName":
            case "lastName":
                $sanitized = htmlspecialchars($input, ENT_NOQUOTES);
                break;
            default:
                break;
        }
        return $sanitized;
    }


    /**
     * Validate user input
     * 
     * @access public
     * @package PhpTraining2\core
     * @param string $input
     * @param string $name The input's name
     * @return mixed The input if validated, false otherwise
     */

    public function validateInput($input, $name) {
        $validated = false;
        $errors = [];
        switch($name) {
            case "email":
                $validated = filter_var($input, FILTER_VALIDATE_EMAIL);
                if(!$validated) $this->addValidationError("email");
                break;
            case "password":
                $validated = strlen($input) > 8;
                if(!$validated) $this->addValidationError("password");
                break;
            case "firstName":
            case "lastName":
                $validated = $input;
                break;
            default:
                break;
        }
        return $validated;
    }

    /**
     * Add an item to the form errors array
     * 
     * @access public
     * @package PhpTraining2\models
     * @param string $$type Type of error: hasEmptyFields, email, password
     */

    public function addValidationError(string $type): void {
        switch ($type) {
            case "hasEmptyFields":
                array_push($this->validationErrors, ["hasEmptyFields" => "All required fields must be filled."]);
                break;
            case 'email':
                array_push($this->validationErrors, ["email" => "Invalid email."]);
                break;
            case "password":
                array_push($this->validationErrors, ["password" => "Password must be at least 8 characters long."]);
                break;
            default:
                break;
        }
    }
}