<?php

namespace PhpTraining2\models\users;

use Exception;
use PhpTraining2\core\Model;
use PhpTraining2\exceptions\UserCreateException;
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

    protected function setId(string|int $id): void 
    {
        if(!intval($id)) {
            throw new RuntimeException("Invalid id type.");
        }
        $this->id = intval($id);
    }

    public function findOne(string $selector): array|bool 
    {
        $this->setWhere($selector);
        $result = $this->find(["email" => $this->email]); // TODO : dynamic property
        return $result;
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

    public function signIn() 
    {
        //
    }

    public function signOut() 
    {
        //
    }

    public function updateOne() 
    {
        //
    }

    public function deleteOne() 
    {
        //
    }

    public function isUserSignedIn(): bool 
    {
        return $_SESSION["user"]["id"];
    }

    private function isValidCredentials() 
    {
        //
    }

    public function alreadyExists(): bool 
    {
        return (bool) $this->findOne("email = :email");
    }
}