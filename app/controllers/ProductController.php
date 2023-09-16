<?php 

namespace PhpTraining2\controllers;

use PhpTraining2\core\Controller;
use PhpTraining2\core\Model;
use PhpTraining2\models\Product;

require_once MODELS_DIR . "Product.php";

class ProductController {
    use Controller;
    use Model;

    private int $id;
    private string $category;

    public function __construct()
    {
        $this->id = intval(strip_tags($_GET["id"]));
        $this->category = strip_tags($_GET["category"]);
    }


    /**
     * Default method of the controller
     * 
     * @access public
     * @package PhpTraining2\controllers
     * 
     */

    public function index(): void {
        $product = new Product();
        $data = $product->getProductData();
        $this->view("pages/product", $data);
    }
};