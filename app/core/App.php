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

        $url = $_GET["url"] ?? "home";
        $url = explode("/", $url);

        return $url;
    }

    /**
     * Loads the controller based on the first part of the url collected in GET superglobal.
     */

    public function loadController() {
        $url = $this->splitUrl();

        /** Select controller **/
        $filename = ucfirst($url[0]);
        $filepath = "../app/controllers/" . $filename . ".ctrl.php";

        $this->controller = $filename;

        if(!file_exists($filepath)) {
            $filepath = "../app/controllers/Error404.ctrl.php";
            $this->controller = "Error404";
        } 
        require_once $filepath;

        /** Select method **/
        $controllerFullName = "\\PhpTraining2\\controllers\\" . $this->controller;
        $controller = new $controllerFullName;

        // call_user_func_array : the first parameter is an array with the class of the function and its name, the second is an array of arguments for the function
        call_user_func_array([$controller, $this->method], []); 
    }
}