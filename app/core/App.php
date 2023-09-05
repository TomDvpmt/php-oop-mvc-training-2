<?php

namespace PhpTraining2\core;

class App {

    private string $controller = "Home"; // default value
    private string $method = "index";

    /**
     * Splits the url collected in the GET superglobal.
     * 
     * @return array
     */

    private function splitUrl() {

        $URL = $_GET["url"] ?? "home";
        $URL = explode("/", $URL);
        return $URL;
    }

    /**
     * Loads the controller based on the first part of the url collected in GET superglobal.
     */

    public function loadController() {
        $URL = $this->splitUrl();

        /** Select controller **/
        $filename = ucfirst($URL[0]);
        $filepath = "../app/controllers/" . $filename . ".ctrl.php";

        $this->controller = $filename;

        if(!file_exists($filepath)) {
            $filepath = "../app/controllers/Error404.ctrl.php";
            $this->controller = "Error404";
        } 
        require_once $filepath;

        $controllerFullName = "\\PhpTraining2\\controllers\\" . $this->controller;
        $controller = new $controllerFullName;

        /** Select method **/
        if(!empty($URL[1])) {
            if(method_exists($controller, $URL[1])) {
                $this->method = $URL[1];
                unset($URL[1]);
            }
        }

        // call_user_func_array : the first parameter is an array with the class of the function and its name, the second is an array of arguments for the function
        call_user_func_array([$controller, $this->method], []); 
    }
}