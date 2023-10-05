<?php

namespace PhpTraining2\core;

class Router {

    use Database;

    private string $controllerName = "HomeController"; // default value
    private string $method = "index";


    /**
     * Create router
     * 
     * Load the controller based on the first part of the url collected in $_GET and the 'action' property in $_GET
     * 
     * @access public
     * @package PhpTraining2\core
     */

     public function create() {
         
        $controller = $this->getController();

        if(!empty($_GET["action"])) {
            $method = strip_tags($_GET["action"]);
            if(method_exists($controller, $method)) {
                $this->setMethod($method);
                unset($method);
            }
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
        $URL = $this->splitUrl();
        $filename = ucfirst($URL[0]);

        $controllerName = $filename . "Controller";
        $this->setControllerName($controllerName);
        
        $filepath = CTRL_DIR . $controllerName . ".php";

        if(!file_exists($filepath)) {
            $filepath = CTRL_DIR . "Error404Controller.php";
            $this->setControllerName("Error404Controller");
            http_response_code(404);
        } 

        require_once $filepath;

        $controllerFullName = "\\PhpTraining2\\controllers\\" . $this->controllerName;
        return new $controllerFullName;
    }


    /**
     * Set controller's name
     * 
     * @access private
     * @package PhpTraining2\core
     * @param string $controllerName (without file extension)
     */

     private function setControllerName(string $controllerName) {
        $this->controllerName = $controllerName;
    }


    /**
     * Set method
     * 
     * @access private
     * @package PhpTraining2\core
     * @param string $methodName (without file extension)
     */

     private function setMethod(string $methodName) {
        $this->method = $methodName;
    }


    /**
     * Split the url collected in the GET superglobal.
     * 
     * @access private
     * @package PhpTraining2\core
     * @return array
     */

     private function splitUrl(): array {
        $URL = $_GET["url"] ?? "home";
        $URL = explode("/", $URL);
        return $URL;
    }
}