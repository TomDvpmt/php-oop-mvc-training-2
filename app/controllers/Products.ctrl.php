<?php

namespace PhpTraining2\controllers;

use PhpTraining2\core\Controller;
use PhpTraining2\core\Model;

class Products {

    use Controller;
    use Model;
    
    public function index() {
        $this->view("pages/products");
    }

}