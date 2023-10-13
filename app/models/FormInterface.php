<?php

namespace PhpTraining2\models;

interface FormInterface {

    /**
     * Get input data
     * 
     * @access public
     * @package PhpTraining2\models\forms
     * @param string $formType Types: "signIn", "signUp"
     * @return array
     */

    function getInputData(string $formType): array;

    /**
     * Add an item to the form errors array
     * 
     * @access public
     * @package PhpTraining2\models
     * @param string $name Error name
     */

    function addValidationError(string $name): void;
}