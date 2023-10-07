<?php 

namespace PhpTraining2\models;

use PhpTraining2\core\Model;

class Category {
    use Model;

    private string $name;
    private string $imgUrl;
    private array $specificProperties;

    public function __construct($name)
    {
        $this->name = $name;
        
        switch ($this->name) {
            case 'books':
                $this->specificProperties = ["genre"];
                break;
            case 'protection':
                $this->specificProperties = ["type", "resistance"];
                break;
            case 'shoes':
                $this->specificProperties = ["waterproof", "level"];
                break;
            case 'vehicles':
                $this->specificProperties = ["airborne", "aquatic"];
                break;
            case 'weapons':
                $this->specificProperties = ["ideal_range"];
                break;
            default:
                $this->specificProperties = [];
                break;
        }
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