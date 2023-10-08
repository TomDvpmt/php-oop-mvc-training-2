<?php 

namespace PhpTraining2\controllers;

use PhpTraining2\core\Controller;
use PhpTraining2\core\Model;

require_once MODELS_DIR . "Product.php";
require_once MODELS_DIR . "Book.php";
require_once MODELS_DIR . "Protection.php";
require_once MODELS_DIR . "Shoe.php";
require_once MODELS_DIR . "Vehicle.php";
require_once MODELS_DIR . "Weapon.php";

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
        $model = $this->getModelNameFromCategoryName($this->category);
        $product = new $model();
        $data = $product->getProductData();
        $this->view("pages/product", $data);
    }
};