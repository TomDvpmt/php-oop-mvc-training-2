<?php

namespace PhpTraining2\controllers;

use PhpTraining2\core\Controller;
use PhpTraining2\core\Model;

class Home {

    use Controller;
    use Model;
    
    public function index() {
        // show($this->findOne(["email" => "test@test.com"]));
        $this->view("pages/home");
    }

}