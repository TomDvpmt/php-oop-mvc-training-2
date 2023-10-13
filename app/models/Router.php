<?php

namespace PhpTraining2\models;

use PhpTraining2\models\Route;

class Router {

    /**
     * Call a route
     * 
     * @access public
     * @package PhpTraining2\models
     */

    public function callRoute(): void {
        $route = $this->createRoute();
        $route->callController();
    }


    /**
     * Create a route
     * 
     * @access private
     * @package PhpTraining2\models
     * @return object
     */

    private function createRoute(): object {

        $path = $_GET["url"] ?? "home";        
        $params = $_GET;
        unset($params["url"]);
                
        //TODO : sanitize $path & $params

        $route = new Route($path, $params);
        return $route;
    }
}