<?php

namespace PhpTraining2\models;

use PhpTraining2\models\Form;

final class ProductForm extends Form {
    

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
            case "price":
                $this->setValidationError("price", "The price must be a number.");
                break;
            
            default:
                break;
        }
    }
}