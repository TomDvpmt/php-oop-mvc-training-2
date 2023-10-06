<?php

namespace PhpTraining2\core;

class App {

    use Database;
    
    /**
     * Load the app's router
     * 
     * @access public
     * @package PhpTraining2\core
     */

    public function loadRouter() {
        $router = new Router();
        $router->callRoute();
    }
}