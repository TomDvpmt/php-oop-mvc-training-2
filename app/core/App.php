<?php

namespace PhpTraining2\core;

class App {

    use Database;
    
    /**
     * Create
     */

    public function loadRouter() {
        $router = new Router();
        $router->callRoute();
    }
}