<?php

class Controller {

    /**
     * Requires a specific view.
     * 
     * @param string $name The view name
     */

    public function view($name) {
        $filename = "../app/views/" . $name . ".view.php";
        if(!file_exists($filename)) {
            $filename = "../app/views/error404.view.php";
        } 
        require $filename;
    }
}