<?php

namespace PhpTraining2\controllers;

use PhpTraining2\core\Controller;

class Error404 {
    use Controller;

    public function index() {
        $this->view("pages/error404");
    }
}