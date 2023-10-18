<?php

namespace PhpTraining2\core;

use PhpTraining2\models\Route;

class Router {

    /**
     * Call a route
     * 
     * @access public
     * @package PhpTraining2\core
     */

    public function callRoute(): void {
        $route = new Route();
        $route->callController();
    }
}