<?php

namespace PhpTraining2\core;

use PhpTraining2\models\Route;

require MODELS_DIR . "Route.php";

class Router {

    // private array $routes = [
    //     "home" => [
    //         "path" => "/",
    //         "controller" => "HomeController",
    //         "method" => "index"
    //     ],
    //     "getProductCategories" => [
    //         "path" => "products",
    //         "controller" => "ProductCategoryController",
    //         "method" => "index"
    //     ],
    //     "getOneProduct" => [
    //         "path" => "products/:productId",
    //         "controller" => "ProductController",
    //         "method" => "displayProduct"
    //     ],
    //     "addProduct" => [
    //         "path" => "products/add",
    //         "controller" => "ProductController",
    //         "method" => "add"
    //     ],
    //     "removeProduct" => [
    //         "path" => "products/:productId/remove",
    //         "controller" => "ProductController",
    //         "method" => "remove"
    //     ],
    //     "user" => [
    //         "path" => "user",
    //         "controller" => "UserController",
    //         "method" => "index",
    //     ],
    //     "getOneUser" => [
    //         "path" => "user/:userId",
    //         "controller" => "UserController",
    //         "method" => "displayUser"
    //     ],
    // ];

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