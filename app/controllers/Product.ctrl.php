<?php 

namespace PhpTraining2\controllers;

use PhpTraining2\core\Controller;
use PhpTraining2\core\Model;

class Product {
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
        $genericData = $this->getProductGenericData();
        $specificData = $this->getProductSpecificData();
        $data = array_merge($genericData, $specificData);

        $this->view("pages/product", $data);
    }

    /**
     * Get the product's generic data (id, name, description, price, image url)
     * 
     * @access private
     * @package PhpTraining2\controllers
     * @return array
     */

    private function getProductGenericData(): array {
        $this->columns = "id, name, description, price, img_url";
        $this->table = "products WHERE id = :id";
        $genericData = (array) $this->find(["id" => $this->id])[0];
        return $genericData;
    }


    /**
     * Get the product's specific data (depending on its category)
     * 
     * @access private
     * @package PhpTraining2\controllers
     * @return array
     */

    private function getProductSpecificData(): array {
        $this->columns = "*";
        $this->table = $this->category . "s WHERE product_id= :product_id";
        $data = (array) $this->find(["product_id" => $this->id])[0];
        $specificData = array_filter($data, fn($key) => !in_array($key, ["id", "product_id"]), ARRAY_FILTER_USE_KEY);
        return $specificData;
    }
};