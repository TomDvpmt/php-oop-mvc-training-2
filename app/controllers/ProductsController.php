<?php

namespace PhpTraining2\controllers;

use PhpTraining2\core\Controller;
use PhpTraining2\core\Model;

abstract class ProductsController {

    use Controller;
    use Model;

    protected string $category = "";
    protected string $model;

    public function __construct()
    {
        $this->setProductCategoryFromURL();
        $this->model = "PhpTraining2\models\products\\" . getModelNameFromTableName($this->category);
    }

    /**
     * Set product category if given in URL
     * 
     * @access private
     * @package PhpTraining2\controllers
     */

    private function setProductCategoryFromURL(): void {
        $pathChunks = $this->getPathChunks();
        $lastChunk = end($pathChunks);
        
        if(count($pathChunks) > 1) {
            $this->setCategory($lastChunk);
        }
        
        if(isset($_GET["category"])) {
            $this->setCategory($_GET["category"]);
        }
    }

    /**
     * Set category of products
     * 
     * @access private
     * @package PhpTraining2\controllers
     */

    private function setCategory(string $category): void {
        $this->category = $category;
    }

    /**
     * Get category of products
     * 
     * @access public
     * @package PhpTraining2\controllers
     */

     public function getCategory(): string {
        return $this->category;
    }
}
