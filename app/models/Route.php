<?php

namespace PhpTraining2\models;

use PhpTraining2\core\ControllerInterface;
use PhpTraining2\controllers\ProductController;

class Route {
    
    private string $controllerName = "HomeController";
    private string $method;

    public function __construct()
    {      
        $this->setMethod();
        $this->setControllerName();
        $userId = $_SESSION["userId"] ?? "none";
        show("userId : " . $userId);
    }

    /**
     * Call a controller
     * 
     * @access public
     * @package PhpTraining2\models
     */

    public function callController() {
        $controller = $this->getControllerObject();
        call_user_func_array([$controller, $this->method], []);
    }


    /**
     * Get controller object
     * 
     * @access private
     * @package PhpTraining2\models
     * @return ControllerInterface The controller
     */

    private function getControllerObject(): ControllerInterface {
        $controllerName = $this->controllerName;
        
        $filepath = CTRL_DIR . $controllerName . ".php";

        if(!file_exists($filepath)) {
            $filepath = CTRL_DIR . "Error404Controller.php";
            $controllerName = "Error404Controller";
            http_response_code(404);
        } 

        require_once $filepath;

        $controllerFullName = "\\PhpTraining2\\controllers\\" . $controllerName;
        return new $controllerFullName;
    }

    /**
     * Set the controller's name
     * 
     * @access private
     * @package PhpTraining2\models
     */

    private function setControllerName(): void {
        $URI = getURI();
        $base = $URI["base"];
        $last = $URI["last"];
        
        $controllerName = empty($base) ? "HomeController" : ucfirst($base) . "Controller";

        if($base === "products") {
            
            $controllerName = "ProductController";
            $this->controllerName = $controllerName;
            $productController = new ProductController();
            
            if(method_exists($productController, $last)) {
                $this->setMethod($last);
                return;
            }
            
            if(!intval($last)) {
                $controllerName = "ProductCategoryController"; 
            }
        }

        $this->controllerName = $controllerName;
    }

    /**
     * Set method
     * 
     * @access private
     * @package PhpTraining2\models
     */

    private function setMethod(string $method = "index"): void {
        $this->method = $_GET["action"] ?? $method;
    }
}