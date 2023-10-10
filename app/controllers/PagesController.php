<?php

namespace PhpTraining2\controllers;

use PhpTraining2\core\Controller;
use PhpTraining2\controllers\ControllerInterface;

class PagesController implements ControllerInterface {
    use Controller;

    public function index(): void {
        $this->view("pages/error404"); // TODO
    }
}