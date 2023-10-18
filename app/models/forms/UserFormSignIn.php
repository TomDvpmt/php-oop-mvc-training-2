<?php

namespace PhpTraining2\models\forms;

use PhpTraining2\models\forms\UserForm;

final class UserFormSignIn extends UserForm {

    /**
     * The fields that need to be validated in the sign in form.
     */
    public const SIGNIN_TO_VALIDATE = ["email"];

    /**
     * The required fields in the sign in form. 
     */
    public const SIGNIN_REQUIRED = ["email", "password"];

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
            "password" => $_POST["password"],
        ];
        return $data;
    }



    /**
     * Get temporary signin data
     * 
     * @access public
     * @package PhpTraining2\models\forms
     * @return array
     */

     public function getTempSignInData(): array 
     {
         $data = [
            "email" => [
                "type" => "email", 
                "value" => $_POST["email"], 
                "name" => "email"
            ],
            "password" => [
                "type" => "password", 
                "value" => $_POST["password"], 
                "name" => "password"
            ],
         ];
         return $data;
     }  
}