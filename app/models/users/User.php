<?php

namespace PhpTraining2\models\users;

use PhpTraining2\core\Model;
use RuntimeException;

abstract class User implements UserInterface {
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

    public function signIn() {
        //
    }

    public function signOut() {
        //
    }

    public function updateOne() {
        //
    }

    public function deleteOne() {
        //
    }

    public function isUserSignedIn(): bool {
        return $_SESSION["user"]["id"];
    }

    private function isValidCredentials() {
        //
    }
}