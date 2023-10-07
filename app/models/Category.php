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
            case 'shoes':
                $this->specificProperties = ["waterproof", "level"];
                break;
            case 'equipment':
                $this->specificProperties = ["activity"];
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
        
        $this->table = "products p JOIN $table $designator";
        $this->where = "p.id = $designator.product_id";
        
        $specific = implode(",", $this->specificProperties);
        $this->columns = "p.id as id, name, description, price, img_url, $specific";
        
        $results = $this->find();
        
        return $results;
    }
}