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
        $this->table = "
            products p JOIN equipments e
            WHERE p.id = e.product_id
        ";
    }

    /**
     * Entry function of the Equipments controller (control the Equipments main page). 
     * 
     * @access public
     * @package PhpTraining2\controllers
     */

    public function index() {
        $content = $this->getPageContent();
        $this->view("pages/equipments", $content);
    }


    /**
     * Get the page's html content
     * 
     * @access private
     * @package PhpTraining2/controllers
     * @return array
     */

    private function getPageContent() {
        $this->columns = "id, name, description, price, img_url, activity";
        $equipments = $this->find();
        
        $content = [];

        foreach($equipments as $item) {
            $equipment = new Equipment(
                $item->id,
                "equipment",
                $item->name, 
                $item->description, 
                $item->price, 
                $item->img_url, // beware of difference between SQL column name (img_url) and php variable (imgUrl)
                $item->activity, 
            );

            $specificHtml = $equipment->getProductSpecificHtml();
            
            array_push($content, $equipment->getProductHtml($specificHtml));
        }
        return $content;
    }

    /**
     * Control the "Add an equipment item" form page. 
     * 
     * @access public
     * @package PhpTraining2\controllers
     */

    public function add() {

        if(isset($_POST["submit"])) {

            $required = ["name", "description", "price", "activity"];

            if($this->hasEmptyFields($required)) {
                $errorMessage = "Empty fields.";
                $this->view("pages/equipment-add", [], $errorMessage, null);
            } else {
                $id = 0;
                $type = "equipment";
                $name = strip_tags($_POST["name"]);
                $description = strip_tags($_POST["description"]);
                $price = $_POST["price"];
                $imgUrl = "";
                $activity = $_POST["activity"];

                $equipment = new Equipment($id, $type, $name, $description, $price, $imgUrl, $activity);
                $specificData = [
                    "activity" => $activity,
                ];

                $equipment->createSpecificProduct($specificData);

                $successMessage = "Equipment added.";
                $this->view("pages/equipment-add", [], null, $successMessage);
            }
        }

        $this->view("pages/equipment-add", [], null, null);
    }
    
}