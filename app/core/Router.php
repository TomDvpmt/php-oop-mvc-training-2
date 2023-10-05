<?php

namespace PhpTraining2\core;

require_once "Route.php";

class Router {

    public function createRoute(): void {

        $path = $_GET["url"] ?? "home";
        
        $params = $_GET;
        unset($params["url"]);
        
        //TODO : sanitize $path & $params

        $route = new Route($path, $params);
        $route->callController();
    }
}