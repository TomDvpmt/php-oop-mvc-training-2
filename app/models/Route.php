<?php

namespace PhpTraining2\models;

class Route {
    
    private string $controllerName = "HomeController";
    private string $method = "index";

    public function __construct(private string $path = "home", private array $params = [])
    {
        $this->setControllerName();
    }

    /**
     * Call a controller
     * 
     * @access public
     * @package PhpTraining2\core
     */

    public function callController() {
        $controller = $this->getController();
        call_user_func_array([$controller, "index"], []);
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
     * Set controller name
     * 
     * @access private
     * @package PhpTraining2\core
     */

     private function setControllerName() {
        $pathChunks = explode("/", $this->path);
        $controllerName = ucfirst($pathChunks[0]) . "Controller";
        $this->controllerName = $controllerName;
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


    /**
     * Get method name from url action parameter
     * 
     * @access private
     * @package PhpTraining2\core
     * @return string
     */

    private function getMethodFromParams(): string {
        $action = $this->params["action"] ?? null;
        return empty($action) ? "index" : strip_tags($action); // TODO : sanitize params in Router
    }


    /**
     * Set method
     * 
     * @access private
     * @package PhpTraining2\core
     * @param string $method
     */

     private function setMethod(string $method) {
        $this->method = $method;
    }
}