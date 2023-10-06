<?php

namespace PhpTraining2\core;

trait Controller {

    /**
     * Requires a specific view.
     * 
     * @access public
     * @package PhpTraining2\core
     * @param string $name The view name
     * @param array $data Array of data to pass to the view
     * @param string $errorMessage Error message to display
     * @param string $successMessage Success message to display
     */

    public function view(string $name, array $data = [], string $errorMessage = null, string $successMessage = null): void {
        if($name === "pages/home") {
            if(!isset($_SESSION["homeCount"])) $_SESSION["homeCount"] = 0;
            $_SESSION["homeCount"]++;
            $this->toggleHomeDisclaimer();
        }
        $filename = "../app/views/" . $name . ".view.php";
        if(!file_exists($filename)) {
            $filename = "../app/views/pages/error404.view.php";
        } 
        require_once $filename;
    }

    /**
     * Send user to the login page
     * 
     * @access public
     * @package PhpTraining2\core
     */

    public function sendToLoginPage(string $redirectionAfter = ""): void {
        $_SESSION["redirectionAfter"] = $redirectionAfter;
        header("Location : " . ROOT . "user?action=login");
    }

    /**
     * Toggle disclaimer on home page
     * 
     * @access private
     * @package PhpTraining2\core
     */

    private function toggleHomeDisclaimer() {
        $_SESSION["disclaimer"] = $_SESSION["homeCount"] <= 1;
    }
}