<?php

namespace PhpTraining2\models\forms;

use PhpTraining2\models\forms\UserForm;

final class UserFormSignUp extends UserForm {
    /**
     * The fields that need to be validated in the signup form.
     */
    public const SIGNUP_TO_VALIDATE = ["firstName", "lastName", "email"];

    /**
     * The required fields in the signup form. 
     */
    public const SIGNUP_REQUIRED = ["email", "password", "passwordConfirm"];

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see FormInterface
     */

    public function getInputData(): array {
        $data = [
            "email" => $_POST["email"],
            "firstName" => $_POST["firstName"],
            "lastName" => $_POST["lastName"],
            "password" => $_POST["password"],
            "passwordConfirm" => $_POST["passwordConfirm"],
        ];
        
        return $data;
    }
}