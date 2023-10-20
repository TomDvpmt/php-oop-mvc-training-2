<?php

namespace PhpTraining2\core;

use PhpTraining2\models\forms\FormInterface;

trait Controller {

    /**
     * Requires a specific view.
     * 
     * @access public
     * @package PhpTraining2\core
     * @param string $name The view name
     * @param array $data Array of data to pass to the view
     */

    public function view(string $name, array $data = []): void {
        $filename = "../app/views/" . $name . ".view.php";
        if(!file_exists($filename)) {
            $filename = "../app/views/pages/error404.view.php";
        } 
        require_once $filename;
    }


    /**
     * Execute the controller's method called in the url
     * 
     * @access public
     * @package PhpTraining2\core
     */

    public function executeMethodIfExists(): void {
        $pathChunks = $this->getPathChunks();
        $method = $this->getMethod($pathChunks);        
        if($method) $this->$method();
    }
    

    /**
     * Get the controller's method called in the url
     * 
     * @access public
     * @package PhpTraining2\core
     * @param array $pathChunks
     * @return string|bool
     */

    public function getMethod($pathChunks): string|bool {
        $lastChunk = end($pathChunks);
        
        if(isset($_GET["action"])) {
            return $_GET["action"];
        }
        
        if(method_exists($this, $lastChunk)) {
            return $lastChunk;
        }

        return false;
    }

    
    /**
     * Get chunks of path from route url
     * 
     * @access public
     * @package PhpTraining2\core
     * @return array
     */
    
    public function getPathChunks(): array {
        $path = $_GET["url"] ?? "home";
        return explode("/", $path);
    }


    /**
     * Show the form with error messages for fields that failed validation
     * 
     * @access private
     * @package PhpTraining2\controllers
     * @param Form $form
     * @param string $page The page where the form is displayed
     */

    protected function showFormWithErrors(FormInterface $form, string $page): void {
        $inputData = $form->getInputData($page);
        $validationErrors = $form->getValidationErrors();
        
        $this->view("pages/$page", ["formData" => $inputData, "validationErrors" => $validationErrors]);
    }


    // /**
    //  * Send user to the signin page
    //  * 
    //  * @access public
    //  * @package PhpTraining2\core
    //  */
    
    // public function sendToSigninPage(string $redirectionAfter = ""): void {
    //     $_SESSION["redirectionAfter"] = $redirectionAfter;
    //     header("Location : " . ROOT . "user/signin");
    // }
}