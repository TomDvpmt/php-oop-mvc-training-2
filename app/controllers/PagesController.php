<?php

namespace PhpTraining2\controllers;

use PhpTraining2\core\Controller;

class PagesController {
    use Controller;

    public function index() {
        $this->view("pages/error404"); // TODO
    }
}