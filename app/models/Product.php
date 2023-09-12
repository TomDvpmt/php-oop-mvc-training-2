<?php

namespace PhpTraining2\models;

use PhpTraining2\core\Model;

class Product {
    use Model;
    
    public function __construct(
        protected int $id = 0,
        protected string $category = "", 
        protected string $name = "", 
        protected string $description = "", 
        protected int $price = 0, 
        protected string $imgUrl = "",
        protected array $reviews = []
    ) {}

    /**
     * Get the product's generic data (id, name, description, price, image url)
     * 
     * @access public
     * @package PhpTraining2\controllers
     * @return array
     */

     public function getProductGenericData(): array {
        $this->columns = "id, name, description, price, img_url";
        $this->table = "products WHERE id = :id";
        $genericData = (array) $this->find(["id" => $this->id])[0];
        return $genericData;
    }


    /**
     * Get the product's specific data (depending on its category)
     * 
     * @access public
     * @package PhpTraining2\controllers
     * @return array
     */

    public function getProductSpecificData(): array {
        $this->columns = "*";
        $this->table = $this->category . "s WHERE product_id= :product_id";
        $data = (array) $this->find(["product_id" => $this->id])[0];
        $specificData = array_filter($data, fn($key) => !in_array($key, ["id", "product_id"]), ARRAY_FILTER_USE_KEY);
        return $specificData;
    }

    /**
     * Add an item to the "products" table and return its id
     * 
     * @access protected
     * @package PhpTraining2\models
     * @return int
     */

    protected function createGenericProduct(): int {
        $this->table = "products";
        $genericData = [
            "category" => $this->category,
            "name" => $this->name,
            "description" => $this->description,
            "price" => $this->price,
            "img_url" => $this->imgUrl,
        ];
        $this->create($genericData);   
        $id = $this->getLastInsertId();
        return $id;
    }

    /**
     * Add an item to a child table of "products" table ("shoes", "equipments", etc.)
     * 
     * @access public
     * @package PhpTraining2\models
     */

    public function createSpecificProduct(array $data): void {
        $id = $this->createGenericProduct();

        $this->table = $this->category . "s";
        $this->orderColumn = "product_id";
        $specificData = array_merge(["product_id" => $id], $data);

        $this->create($specificData);
    }


    /**
     * Get HTML code for a product
     * 
     * @access public
     * @package PhpTraining2\models
     * @return string
     */

     public function getProductCardHtml(string $specificHtml): string {
        ob_start();
        require VIEWS_DIR . "partials/product-card.php";
        $html = ob_get_clean();
        
        return $html;
    }
}