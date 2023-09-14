<?php

namespace PhpTraining2\core;

class App {

    use Database;

    private string $controller = "HomeController"; // default value
    private string $method = "index";

    /**
     * Splits the url collected in the GET superglobal.
     * 
     * @return array
     */

    private function splitUrl(): array {
        $URL = $_GET["url"] ?? "home";
        $URL = explode("/", $URL);
        return $URL;
    }
    
    /**
     * Router (loads the controller based on the first part of the url collected in $_GET and the 'action' property in $_GET)
     */

    public function router() {
        $URL = $this->splitUrl();
        
        /** Select controller **/
        $filename = ucfirst($URL[0]);
        $filepath = CTRL_DIR . $filename . "Controller.php";

        $this->controller = $filename . "Controller";

        if(!file_exists($filepath)) {
            $filepath = CTRL_DIR . "Error404Controller.php";
            $this->controller = "Error404Controller";
        } 
        require_once $filepath;

        $controllerFullName = "\\PhpTraining2\\controllers\\" . $this->controller;
        $controller = new $controllerFullName;

        /** Select method **/
        
        if(!empty($_GET["action"])) {
            $method = strip_tags($_GET["action"]);
            if(method_exists($controller, $method)) {
                $this->method = $method;
                unset($method);
            }
        }

        // call_user_func_array : the first parameter is an array with the class of the function and its name, the second is an array of arguments for the function
        call_user_func_array([$controller, $this->method], []); 
    }
}