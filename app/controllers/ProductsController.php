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
        $pathChunks = $this->getPathChunks();
        $lastChunk = end($pathChunks);
        if(count($pathChunks) > 1) {
            $this->category = $lastChunk;
        }
        
        if(isset($_GET["category"])) {
            $this->category = $_GET["category"];
        }    

        $this->model = getModelNameFromCategoryName($this->category);
    }
}
