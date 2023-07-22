<?php

namespace PhpTraining2\core;

class App {

    private string $controller = "Home";
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
        $filename = ucfirst($url[0]);
        $filepath = "../app/controllers/" . $filename . ".php";

        $this->controller = $filename;

        if(!file_exists($filepath)) {
            $filepath = "../app/controllers/Error404.php";
            $this->controller = "Error404";
        } 
        require $filepath;

        $controllerFullName = "\\PhpTraining2\\controllers\\" . $this->controller;
        $controller = new $controllerFullName;
        call_user_func_array([$controller, $this->method], []);
    }
}