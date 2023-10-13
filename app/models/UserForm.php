<?php

namespace PhpTraining2\models;

use PhpTraining2\models\Form;

final class UserForm extends Form {
    
    /**
     * The fields that need to be validated in the signup form.
     */
    public const REGISTER_TO_VALIDATE = ["firstName", "lastName", "email"];

    /**
     * The required fields in the signup form. 
     */
    public const REGISTER_REQUIRED = ["email", "password", "passwordConfirm"];

    public function __construct()
    {
        parent::__construct();
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
            case 'emailInvalid':
                $this->setValidationError("emailInvalid", "Invalid email.");
                break;
            case 'emailAlreadyUsed':
                $this->setValidationError("emailAlreadyUsed", "This email address is already used, please choose another one.");
                break;
            case "password":
                $this->setValidationError("password", "Password must be at least 8 characters long.");
                break;
            case "passwordsDontMatch": 
                $this->setValidationError("passwordsDontMatch", "Passwords don't match.");
            default:
                break;
        }
    }
}