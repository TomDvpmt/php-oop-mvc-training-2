<?php 

namespace PhpTraining2\models;

use PhpTraining2\core\Model;

class ProductCategory {
    use Model;

    private string $name;
    private string $imgUrl;
    private array $specificProperties;

    public function __construct($name)
    {
        $this->name = $name;

        $productModelName = getModelNameFromCategoryName($name);
        $options = (new $productModelName)->getSelectOptions();
        $this->specificProperties = array_keys($options["questions"]);
    }

    /**
     * Get this category's specific properties
     * 
     * @access public
     * @package PhpTraining2\models
     * @return array
     */

    public function getSpecificProperties(): array {
        return $this->specificProperties;
    }

    /**
     * Get all products of this category
     * 
     * @access public
     * @package PhpTraining2\models
     * @return array
     */

     public function getProductsOfCategory(): array {
        $table = $this->name;
        $designator = substr($this->name, 0, 1);
        if($designator === "p") {
            $designator = "spec";
        }
        
        $this->table = "products p JOIN $table $designator";
        $this->where = "p.id = $designator.product_id";
        
        $specific = implode(",", $this->specificProperties);
        $this->columns = "p.id as id, name, description, special_features, limitations, price, img_url, $specific";
        
        $results = $this->find();
        if(empty($results)) {
            $results = [];
        }
        
        return $results;
    }
}