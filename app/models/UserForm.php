<?php

namespace PhpTraining2\models;

use PhpTraining2\models\Form;

final class UserForm extends Form {
    
    /**
     * The fields that need to be validated in the signup form.
     */
    const REGISTER_TO_VALIDATE = ["firstName", "lastName", "email"];

    /**
     * The required fields in the signup form. 
     */
    const REGISTER_REQUIRED = ["email", "password", "passwordConfirm"];

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
                $this->validationErrors["emailInvalid"] = "Invalid email.";
                break;
            case 'emailAlreadyUsed':
                $this->validationErrors["emailAlreadyUsed"] = "This email address is already used, please choose another one.";
                break;
            case "password":
                $this->validationErrors["password"] = "Password must be at least 8 characters long.";
                break;
            case "passwordsDontMatch": 
                $this->validationErrors["passwordsDontMatch"] = "Passwords don't match.";
            default:
                break;
        }
    }
}