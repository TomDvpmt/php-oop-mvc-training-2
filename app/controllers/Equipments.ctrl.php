<?php

namespace PhpTraining2\controllers;

use PhpTraining2\core\Controller;
use PhpTraining2\core\Model;
use PhpTraining2\models\Equipment;

require_once MODELS_DIR . "Equipment.php";

class Equipments {

    use Controller;
    use Model;

    public function __construct()
    {
        $this->table = "equipments";
    }

    /**
     * Entry function of the Equipments controller (control the Equipments main page). 
     * 
     * @access public
     * @package PhpTraining2\controllers
     */


    public function index() {
        $equipments = $this->findAll();
        $content = [];

        foreach($equipments as $item) {
            $equipment = new Equipment(
                $item->id,
                $item->name, 
                $item->description, 
                $item->price, 
                $item->img_url, // beware of difference between SQL column name (img_url) and php variable (imgUrl)
                $item->activity, 
            );

            $specificHtml = $equipment->getProductSpecificHtml();
            
            array_push($content, $equipment->getProductHtml($specificHtml));
        }

        $this->view("pages/equipments", $content);
    }

    /**
     * Control the "Add an equipment item" form page. 
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
            $activity = $_POST["product-activity"];
            
            if(!empty($name) && !empty($description) && !empty($price) && !empty($activity)) {

                $equipment = new Equipment($name, $description, $price, $imgUrl, $activity);
                $equipment->createProduct(["activity" => $activity]);
                $successMessage = "Equipment added.";
                $this->view("pages/equipment-add", [], null, $successMessage);
                
            } else {
                $errorMessage = "Empty fields.";
                $this->view("pages/equipment-add", [], $errorMessage, null);
            }
        }

        $this->view("pages/equipment-add", [], null, null);
    }
    
}