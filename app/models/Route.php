<?php

namespace PhpTraining2\models;

class Route {
    
    private string $controllerName = "HomeController";

    public function __construct(private string $path = "home", private array $params = [])
    {
        
        show($this->path);
        
        $pathChunks = explode("/", $this->path);
        $base = $pathChunks[0];
        $controllerName = ucfirst($base) . "Controller";

        if($base === "products") {
            $controllerName = isset($_GET["id"]) ? "ProductController" : "ProductCategoryController"; 
        }

        $this->controllerName = $controllerName;
    }

    /**
     * Call a controller
     * 
     * @access public
     * @package PhpTraining2\core
     */

    public function callController() {
        $controller = $this->getControllerObject();
        call_user_func_array([$controller, "index"], []);
    }


    /**
     * Get controller object
     * 
     * @access private
     * @package PhpTraining2\core
     * @return object The controller
     */

    private function getControllerObject(): object {
        $controllerName = $this->getControllerName();
        
        $filepath = CTRL_DIR . $controllerName . ".php";

        if(!file_exists($filepath)) {
            $filepath = CTRL_DIR . "Error404Controller.php";
            $controllerName = "Error404Controller";
            http_response_code(404);
        } 

        require_once $filepath;

        $controllerFullName = "\\PhpTraining2\\controllers\\" . $controllerName;
        return new $controllerFullName;
    }


    /**
     * Get controller name
     * 
     * @access private
     * @package PhpTraining2\core
     * @return string
     */

    private function getControllerName(): string {
        return $this->controllerName;
    }
}