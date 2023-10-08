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
     * Get model name from category name
     * 
     * @access public
     * @package PhpTraining2\core
     * @return string
     */

    public function getModelNameFromCategoryName($category): string {
        $model = substr($category, -1) === "s" ? substr($category, 0, -1) : $category;
        return "PhpTraining2\\models\\" . ucfirst($model);
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