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
        $this->table = "
            products p JOIN shoes s
            WHERE p.id = s.product_id
        ";
    }

    /**
     * Entry function of the Shoes controller (control the Shoes main page). 
     * 
     * @access public
     * @package PhpTraining2\controllers
     */

    public function index() {
        $content = $this->getPageContent();
        $this->view("pages/shoes", $content);
    }


    /**
     * Get the page's html content
     * 
     * @access private
     * @package PhpTraining2/controllers
     * @return array
     */

     private function getPageContent() {
        $this->columns = "id, name, description, price, img_url, waterproof, level";
        $shoes = $this->find();

        $content = [];

        foreach($shoes as $item) {
            $shoe = new Shoe(
                $item->id,
                "shoe",
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
        return $content;
     }
  

    /**
     * Control the "Add a shoe item" form page. 
     * 
     * @access public
     * @package PhpTraining2\controllers
     */

    public function add() {

        if(isset($_POST["submit"])) {
            
            $required = ["name", "description", "price", "waterproof", "level"];
            
            if($this->hasEmptyFields($required)) {
                $errorMessage = "Empty fields.";
                $this->view("pages/shoe-add", [], $errorMessage, null);
            } else {
                $id = 0;
                $type = "shoe";
                $name = strip_tags($_POST["name"]);
                $description = strip_tags($_POST["description"]);
                $price = intval($_POST["price"]);
                $imgUrl = "";
                $waterproof = $_POST["waterproof"] === "yes" ? 1 : 0;
                $level = $_POST["level"];
                
                $shoe = new Shoe($id, $type, $name, $description, $price, $imgUrl, $waterproof, $level);

                $specificData = [
                    "waterproof" => $waterproof,
                    "level" => $level,
                ];
                $shoe->createSpecificProduct($specificData);

                $successMessage = "Shoe added.";
                $this->view("pages/shoe-add", [], null, $successMessage);
            }
        }

        $this->view("pages/shoe-add", [], null, null);
    }

    
    
}