<?php

namespace PhpTraining2\core;

class Router {

    /**
     * Call a route
     * 
     * @access public
     * @package PhpTraining2\core
     */

    public function callRoute(): void {
        $route = $this->createRoute();
        $route->callController();
    }


    /**
     * Create a route
     * 
     * @access private
     * @package PhpTraining2\core
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