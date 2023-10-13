<?php

namespace PhpTraining2\models;

use PhpTraining2\controllers\ControllerInterface;
use PhpTraining2\controllers\ProductController;

class Route {
    
    private string $controllerName = "HomeController";
    private string $method = "index";

    public function __construct()
    {      
        $this->setControllerName();
    }

    /**
     * Call a controller
     * 
     * @access public
     * @package PhpTraining2\core
     */

    public function callController() {
        $controller = $this->getControllerObject();
        call_user_func_array([$controller, $this->method], []);
    }


    /**
     * Get controller object
     * 
     * @access private
     * @package PhpTraining2\core
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
        $base = getURI()["base"];
        $last = getURI()["last"];
        
        $controllerName = empty($base) ? "HomeController" : ucfirst($base) . "Controller";

        if($base === "products") {
            
            $controllerName = "ProductController";
            $this->controllerName = $controllerName;
            $productController = new ProductController();
            
            if(method_exists($productController, $last)) {
                $this->method = $last;
                return;
            }
            
            if(!intval($last)) {
                $controllerName = "ProductCategoryController"; 
            }
        }

        $this->controllerName = $controllerName;
    }
}