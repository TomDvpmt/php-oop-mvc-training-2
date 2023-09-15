<?php

namespace PhpTraining2\models;

use PhpTraining2\core\Model;

class User {
    use Model;

    public function __construct(
        private int $id = 0, 
        private string $firstName = "", 
        private string $lastName = "", 
        private string $email, 
        private string $password,
        private string $passwordConfirm,
        private int $isAdmin = 0
    )
    {
        if(isset($_SESSION["user"]["id"])) {
            $this->id = $_SESSION["user"]["id"];
        }
    }

    public function createUser() {
        
    }

    public function login() {
        //
    }

    public function updateUser() {
        //
    }

    public function deleteUser() {
        //
    }

    public function isUserLoggedIn(): bool {
        return $_SESSION["user"]["id"];
    }

    private function isValidCredentials() {
        //
    }
}