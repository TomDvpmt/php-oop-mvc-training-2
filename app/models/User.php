<?php

namespace PhpTraining2\models;

class User {
    public function __construct(private int $id = 0)
    {
        if(isset($_SESSION["user"]["id"])) {
            $this->id = htmlspecialchars($_SESSION["user"]["id"]);
        }
    }
}