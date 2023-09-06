<?php

namespace PhpTraining2\controllers;

use PhpTraining2\core\Controller;
use PhpTraining2\core\Model;
use PhpTraining2\models\Product;
require_once MODELS_DIR . "Product.php";

class Shoes {

    use Controller;
    use Model;

    public function __construct()
    {
        $this->table = "shoes";
    }

    /**
     * Entry function of the Shoes controller (control the Shoes main page). 
     * 
     * @access public
     * @package PhpTraining2\controllers
     */


    public function index() {
        $shoes = $this->getAllShoes();
        $content = [];

        foreach($shoes as $item) {
            $shoe = new Product($item->name, $item->description, $item->price);
            array_push($content, $shoe->getProductHtml());
        }

        $this->view("pages/shoes", $content);
    }

    /**
     * Get an array of all the shoes from database. 
     * 
     * @access private
     * @package PhpTraining2\controllers
     * @return array
     */

    private function getAllShoes() {
        $shoes = $this->findAll();
        return $shoes;
    }
    
}