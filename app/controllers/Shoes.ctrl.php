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
        $shoes = $this->findAll();
        $content = [];

        foreach($shoes as $item) {
            $shoe = new Shoe(
                $item->id,
                $item->name, 
                $item->description, 
                $item->price, 
                $item->img_url, // beware of difference between SQL column name (img_url) and php variable (imgUrl)
                $item->waterproof, 
                $item->level
            );
            $specificHtml = $shoe->getProductSpecificHtml();
            array_push($content, $shoe->getProductHtml($specificHtml));
        }

        $this->view("pages/shoes", $content);
    }
  

    /**
     * Control the "Add a shoe item" form page. 
     * 
     * @access public
     * @package PhpTraining2\controllers
     */

    public function add() {

        if(isset($_POST["product-name"])) {
            
            $name = strip_tags($_POST["product-name"]);
            $description = strip_tags($_POST["product-description"]);
            $price = $_POST["product-price"];
            $imgUrl = "";
            $waterproof = $_POST["product-waterproof"];
            $level = $_POST["product-level"];
            
            if(!empty($name) && !empty($description) && !empty($price) && !empty($waterproof) && !empty($level)  ) {

                $waterproof = $waterproof === "yes" ? 1 : 0;

                $shoe = new Shoe($name, $description, $price, $imgUrl, $waterproof, $level);
                $shoe->createProduct(["waterproof" => $waterproof, "level" => $level]);
                $successMessage = "Shoe added.";
                $this->view("pages/shoe-add", [], null, $successMessage);
                
            } else {
                $errorMessage = "Empty fields.";
                $this->view("pages/shoe-add", [], $errorMessage, null);
            }
        }

        $this->view("pages/shoe-add", [], null, null);
    }
    
}