<?php

namespace PhpTraining2\controllers;

use PhpTraining2\core\Controller;
use PhpTraining2\core\Model;
use PhpTraining2\models\Equipment;

require_once CTRL_DIR . "Products.ctrl.php";
require_once MODELS_DIR . "Equipment.php";

class Equipments extends Products {

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
        $equipments = parent::getAllProducts();
        $content = [];

        foreach($equipments as $item) {
            $equipment = new Equipment(
                $item->name, 
                $item->description, 
                $item->price, 
                $item->img_url, // beware of difference between SQL column name (img_url) and php variable (imgUrl)
                $item->activity, 
            );
            array_push($content, $equipment->getProductHtml());
        }

        $this->view("pages/equipments", $content);
    }
    
}