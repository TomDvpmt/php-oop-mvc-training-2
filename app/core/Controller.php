<?php

namespace PhpTraining2\core;

trait Controller {

    /**
     * Requires a specific view.
     * 
     * @access public
     * @param string $name The view name
     * @param array $data Array of data to pass to the view
     * @param string $errorMessage Error message to display
     * @param string $successMessage Success message to display
     */

    public function view(string $name, array $data = [], string $errorMessage = null, string $successMessage = null) {
        $filename = "../app/views/" . $name . ".view.php";
        if(!file_exists($filename)) {
            $filename = "../app/views/pages/error404.view.php";
        } 
        require_once $filename;
    }
}