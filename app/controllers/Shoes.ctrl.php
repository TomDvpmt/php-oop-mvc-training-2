<?php

namespace PhpTraining2\controllers;

use PhpTraining2\core\Controller;
use PhpTraining2\core\Model;
use PhpTraining2\models\Shoe;
require_once MODELS_DIR . "Shoe.php";

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
            $shoe = new Shoe(
                $item->name, 
                $item->description, 
                $item->price, 
                $item->img_url, // beware of difference between SQL column name (img_url) and php variable (imgUrl)
                $item->waterproof, 
                $item->level
            );
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