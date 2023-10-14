<?php

namespace PhpTraining2\models\forms;

use PhpTraining2\models\forms\Form;

abstract class UserForm extends Form {
    
    public function __construct()
    {
        parent::__construct();
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