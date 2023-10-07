<?php

namespace PhpTraining2\models;

use PhpTraining2\core\Model;

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
        $this->table = "users";
        if(isset($_SESSION["user"]["id"])) {
            $this->id = $_SESSION["user"]["id"];
        }
    }

    public function findOne() {
        $this->setWhere("email = :email");
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