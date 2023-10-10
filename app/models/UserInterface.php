<?php

namespace PhpTraining2\models;

interface UserInterface {

    /**
     * Find a user
     * 
     * @access public
     * @package PhpTraining2\models
     * @return object
     */
    function findOne(): object;

    function createOne();

    function signin();

    function updateOne();

    function deleteOne();

    function isUserLoggedIn(): bool;
}