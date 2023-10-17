<?php

namespace PhpTraining2\models\products;

interface ProductInterface {

    /**
     * Get the product's full data (generic + specific) from database
     * 
     * @access public
     * @package PhpTraining2\models\products
     * @return array
     */

    function getProductDataFromDB(): array;

    /**
     * Get select options for add product form
     * 
     * @access public
     * @package PhpTraning2\models\products
     * @return array
     */
    function getSelectOptions(): array;
}