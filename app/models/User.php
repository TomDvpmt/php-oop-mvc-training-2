<?php

namespace PhpTraining2\models;

use PhpTraining2\core\Model;
use RuntimeException;

class User {
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
        if(isset($_SESSION["user"]["id"])) {
            $this->id = $_SESSION["user"]["id"];
        }
    }

    /**
     * Set user id
     * 
     * @access protected
     * @package PhpTraining2\models
     */

    protected function setId(string|int $id): void {
        if(!intval($id)) {
            throw new RuntimeException("Invalid id type.");
        }
        $this->id = intval($id);
    }

    /**
     * Get a user from the database
     * 
     * @access public
     * @package PhpTraining2\models
     * @param string $selector Example : "email = :email"
     */

    public function findOne(string $selector): object {
        $this->setWhere($selector);
        $result = $this->find(["email" => $this->email]);
        return $result;
    }


    public function createOne() {
        $this->create([
            "first_name" => $this->firstName,
            "last_name" => $this->lastName,
            "email" => $this->email,
            "password" => $this->password,
        ]);
    }

    public function signin() {
        //
    }

    public function updateOne() {
        //
    }

    public function deleteOne() {
        //
    }

    public function isUserLoggedIn(): bool {
        return $_SESSION["user"]["id"];
    }

    private function isValidCredentials() {
        //
    }
}