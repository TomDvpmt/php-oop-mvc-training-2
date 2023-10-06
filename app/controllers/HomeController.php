<?php

namespace PhpTraining2\controllers;

use PhpTraining2\core\Controller;
use PhpTraining2\core\Model;

class HomeController {

    use Controller;
    use Model;

    public function __construct()
    {   
        $this->incrementHomeCount();
        $this->toggleHomeDisclaimer();
    }
    
    public function index() {
        $this->view("pages/home");
    }

    /**
     * Increment home page visits count for this session
     * 
     * @access private
     * @package PhpTraining2\controllers
     */

     private function incrementHomeCount() {
        if(!isset($_SESSION["homeCount"])) $_SESSION["homeCount"] = 0;
        $_SESSION["homeCount"]++;
    }

    /**
     * Toggle disclaimer on home page
     * 
     * @access private
     * @package PhpTraining2\controllers
     */

    private function toggleHomeDisclaimer() {
        $_SESSION["disclaimer"] = $_SESSION["homeCount"] <= 1;
    }

}