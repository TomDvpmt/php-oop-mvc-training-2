<?php

namespace PhpTraining2\controllers;

use PhpTraining2\core\Controller;

class Home {

    use Controller;
    
    public function index() {
        $this->view("home");
        
    }
}