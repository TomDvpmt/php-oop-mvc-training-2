<?php

namespace PhpTraining2\models\users;

interface UserInterface {

    /**
     * Get a user from the database
     * 
     * @access public
     * @package PhpTraining2\models
     * @param string $selector Example : "email = :email"
     * @return array
     */
    
    function findOne(string $selector): array|bool;

    function createOne();

    function signIn();

    function signOut();

    function updateOne();

    function deleteOne();

    function isUserSignedIn(): bool;
}