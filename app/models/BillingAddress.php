<?php

namespace PhpTraining2\models;

use PhpTraining2\core\Model;

class BillingAddress {

    use Model;

    public function __construct(private array $data = [])
    {
        $this->setTable("user_billing_addresses");
        $this->setOrderColumn("address_slug");
        $this->data = $data;
    }


    /**
     * Get a user's registered billing addresses
     * 
     * @access public
     * @package PhpTraining2\models
     * @param int $userId
     * @return array|null
     */

     public function getAll(int $userId): array|null {
        $this->setWhere("user_id = :id");
        $results = $this->find(["id" => $userId]);
        
        if(!$results) return null;
        
        $addresses = array_map(fn($item) => (array) $item, $results);
        return $addresses;
    }


    /**
     * Get a billing address (by its slug)
     * 
     * @access public
     * @package PhpTraining2\models
     * @param string $addressSlug
     * @return array|null
     */

    public function getOne(string $addressSlug): array|null { // TODO : remove if unused
        $this->setWhere("address_slug = :address_slug");
        $result = $this->find(["address_slug" => $addressSlug]);
        return $result ? (array) $result[0] : null;
    }

    
    /**
     * Save billing address in the database
     * 
     * @access public
     * @package PhpTraining2\models
     */

     public function saveBillingAddress(): void {
        $data = $this->data;
        $data["user_id"] = $_SESSION["userId"];
        $this->create($data);
    }

}