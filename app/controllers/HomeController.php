<?php

namespace PhpTraining2\controllers;

use PhpTraining2\core\Controller;
use PhpTraining2\core\Model;
use PhpTraining2\core\ControllerInterface;

class HomeController implements ControllerInterface {

    use Controller;
    use Model;

    public function __construct()
    {   
        $this->incrementHomeCount();
        $this->toggleHomeDisclaimer();
    }
    
    public function index(): void {
        $this->view("pages/home");
    }

    /**
     * Increment home page visits count for this session
     * 
     * Usage: for the disclaimer, which is shown only on first visit of the homepage
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