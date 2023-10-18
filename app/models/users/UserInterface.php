<?php

namespace PhpTraining2\models\users;

interface UserInterface {

    /**
     * Get a user from the database
     * 
     * @access public
     * @package PhpTraining2\models
     * @param string $selector Example : "email = :email"
     * @param mixed $value The selector value
     * @return array
     */
    
    function getOne(string $selector, mixed $value): array|bool;

    function createOne();

    function updateOne();

    function deleteOne();
}