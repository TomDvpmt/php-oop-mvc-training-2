<?php

namespace PhpTraining2\models\users;

use Exception;
use PhpTraining2\core\Model;
use PhpTraining2\exceptions\UserCreateException;
use PhpTraining2\models\BillingAddress;
use RuntimeException;

class User implements UserInterface {
    use Model;

    public function __construct(
        private int $id = 0, 
        private int $isAdmin = 0,
        private string $firstName = "", 
        private string $lastName = "", 
        private string $email = "", 
        private string $password = "",
    )
    {
        $this->setTable("users");

        if(isset($_SESSION["userId"])) {
            $this->setId($_SESSION["userId"]);
        }
    }

    /**
     * Set user id
     * 
     * @access protected
     * @package PhpTraining2\models\users
     */

    protected function setId(int $id): void 
    {
        if(!intval($id)) {
            throw new RuntimeException("Invalid id type.");
        }
        $this->id = intval($id);
    }


    /**
     * Set user email
     * 
     * @access public
     * @package PhpTraining2\models\users
     */

    public function setEmail(string $email): void 
    {
        $this->email = $email;
    }

    /**
     * Get a user
     * 
     * @access public
     * @package PhpTraining2\models\users
     * @return array|null
     */

    public function getOne(string $selector, mixed $value): array|null 
    {
        $this->setWhere("$selector = :$selector");
        $result = $this->find([$selector => $value]);
        return $result ? (array) $result[0] : null;
    }


    /**
     * Get a user by its id
     * 
     * @access public
     * @package PhpTraining2\models\users
     * @return array|null
     */

    public function getOneById(): array|null {
        $this->setWhere("id = :id");
        $result = $this->find(["id" => $this->id]);
        return $result ? (array) $result[0] : null;
    }



    public function createOne() 
    {
        try {
            $this->create([
                "first_name" => $this->firstName,
                "last_name" => $this->lastName,
                "email" => $this->email,
                "password" => $this->password,
            ]);
            return true;
        } catch (Exception $e) {
            throw new UserCreateException();
        }
    }

    public function updateOne() 
    {
        //
    }

    public function deleteOne() 
    {
        //
    }

    public function alreadyExists(): bool 
    {
        return (bool) $this->getOne("email = :email", $this->email);
    }

    public function getOrders(): array {
        return [];
    }

    
    /**
     * Get user's registered billing addresses
     * 
     * @access public
     * @package PhpTraining2\models\users
     * @return array|null
     */

    public function getBillingAddresses(): array|null {
        $address = new BillingAddress();
        $userId = $this->id;
        $addresses = $address->getAll($userId);
        return $addresses;
    }
}