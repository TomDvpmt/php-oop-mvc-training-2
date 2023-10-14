<?php

namespace PhpTraining2\models;

interface FormInterface {

    /**
     * Get input data
     * 
     * @access public
     * @package PhpTraining2\models\forms
     * @return array
     */

    function getInputData(): array;

    // /**
    //  * Add an item to the form errors array
    //  * 
    //  * @access public
    //  * @package PhpTraining2\models
    //  * @param string $name Error name
    //  */

    // function addValidationError(string $name): void;
}