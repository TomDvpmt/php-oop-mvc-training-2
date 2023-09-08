<?php

namespace PhpTraining2\controllers;

use PhpTraining2\core\Controller;
use PhpTraining2\core\Model;
use PhpTraining2\models\Shoe;
use PhpTraining2\models\Equipment;

require_once MODELS_DIR . "Product.php";

class Products {

    use Controller;
    use Model;

    /**
     * Get an array of all the products from database. 
     * 
     * @access private
     * @package PhpTraining2\controllers
     * @return array
     */

    protected function getAllProducts() {
        $products = $this->findAll();
        return $products;
    }
}