<?php

namespace PhpTraining2\core;

class Route {
    
    private string $controllerName = "HomeController";
    private string $method = "index";

    public function __construct(private string $path = "home", private array $params = [])
    {
        $controllerName = ucfirst(explode("/", $this->path)[0]) . "Controller";
        $this->controllerName = $controllerName;
    }

    /**
     * Call a controller (and its specific method)
     * 
     * @access public
     * @package PhpTraining2\core
     */

    public function callController() {
        $controller = $this->getController();
        $method = $this->getMethodFromParams();
        
        if(method_exists($controller, $method)) {
            $this->setMethod($method);
        }

        call_user_func_array([$controller, $this->method], []);
    }


    /**
     * Get controller object
     * 
     * @access private
     * @package PhpTraining2\core
     * @return object The controller
     */

    private function getController(): object {
        $controllerName = $this->getControllerName();
        show($controllerName);
        
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
     * Get controller's name
     * 
     * @access private
     * @package PhpTraining2\core
     * @return string
     */

    private function getControllerName(): string {
        return $this->controllerName;
    }


    /**
     * Get method name from url action parameter
     * 
     * @access private
     * @package PhpTraining2\core
     * @return string
     */

    private function getMethodFromParams(): string {
        $action = $this->params["action"] ?? null;
        return empty($action) ? "index" : strip_tags($action);
        
    }


    /**
     * Set method
     * 
     * @access private
     * @package PhpTraining2\core
     * @param object $controller
     */

     private function setMethod(string $method) {
        $this->method = $method;
    }
}