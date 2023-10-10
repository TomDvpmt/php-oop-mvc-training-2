<?php

namespace PhpTraining2\models;

interface ProductInterface {

    /**
     * Get the product's full data (generic + specific)
     * 
     * @access public
     * @package PhpTraining2\models
     * @return array
     */

    function getProductData(): array;

    /**
     * Get select options for add product form
     * 
     * @access public
     * @package PhpTraning2/models
     * @return array
     */
    function getSelectOptions(): array;
}