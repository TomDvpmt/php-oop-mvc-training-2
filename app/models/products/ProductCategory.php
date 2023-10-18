<?php 

namespace PhpTraining2\models\products;

use PhpTraining2\core\Model;

class ProductCategory {
    use Model;

    public const PRODUCT_CATEGORIES_THUMB_DIR = "assets/images/products/categories/";

    private string $name = "";
    private array $specificProperties = [];

    public function __construct($name)
    {
        $this->name = $name;
        $this->setSpecificProperties();
    }
    

    /**
     * Set specific properties of this product category
     * 
     * @access private
     * @package PhpTraining2\models\products
     */
    
    private function setSpecificProperties(): void {
        $productModelName = "PhpTraining2\models\products\\" . getModelNameFromTableName($this->name);
        $options = (new $productModelName)->getSelectOptions();
        $this->specificProperties = array_keys($options["questions"]);
    }

    /**
     * Get this category's specific properties
     * 
     * @access public
     * @package PhpTraining2\models\products
     * @return array
     */

    public function getSpecificProperties(): array {
        return $this->specificProperties;
    }

    /**
     * Get all products of this category
     * 
     * @access public
     * @package PhpTraining2\models\products
     * @return array
     */

     public function getProductsOfCategory(): array {
        $table = $this->name;
        $designator = substr($this->name, 0, 1);
        if($designator === "p") {
            $designator = "spec";
        }
        
        $this->setTable("products p JOIN $table $designator");
        $specific = implode(",", $this->specificProperties);
        $this->setColumns("p.id as id, name, description, special_features, limitations, price, thumbnail, $specific"); // TODO : dynamic columns
        $this->setWhere("p.id = $designator.product_id");
        
        $results = $this->find();
        if(empty($results)) {
            $results = [];
        }
        
        return $results;
    }

    /**
     * Get this category thumbnail's URL
     * 
     * @access public
     * @package PhpTraining2\models\products
     */

    public function getThumbnail(): string {
        $thumbs = array_slice(scandir(self::PRODUCT_CATEGORIES_THUMB_DIR), 2); // offset = 2 to avoid including "." and ".." directories
        $thumbnail = array_filter($thumbs, fn($thumb) => str_contains($thumb, $this->name));
        $thumbnailFileName = array_values($thumbnail)[0];
        return self::PRODUCT_CATEGORIES_THUMB_DIR . $thumbnailFileName;
    }
}