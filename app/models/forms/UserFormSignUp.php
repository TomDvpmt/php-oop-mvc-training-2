<?php

namespace PhpTraining2\models\forms;

use PhpTraining2\exceptions\FormPasswordsDontMatchException;
use PhpTraining2\models\forms\UserForm;

final class UserFormSignUp extends UserForm {
    /**
     * The fields that need to be validated in the signup form.
     */
    public const SIGNUP_TO_VALIDATE = ["firstName", "lastName", "email", "password"];

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

    /**
     * Get signup data
     * 
     * @access public
     * @package PhpTraining2\models\forms
     * @return array
     */

     public function getTempSignUpData(): array 
     {
         $data = [ // beware of properties order, must match class User constructor (TODO : find a better way to do this)
             "notToValidate" => [
                 "id" => 0,                 
                 "isAdmin" => 0,
             ],
             "toValidate" => [
                 "firstName" => [
                     "type" => "text", 
                     "value" => $_POST["firstName"], 
                     "name" => "firstName"
                 ],
                 "lastName" => [
                     "type" => "text", 
                     "value" => $_POST["lastName"], 
                     "name" => "lastName"
                 ],
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
             ],
         ];
         return $data;
     }  
 
 
     /**
      * Get hashed password
      * 
      * @access public
      * @package PhpTraining2\models\forms
      * @param string $password The password entered by the user
      * @return string
      */
 
     public function getHashedPassword(string $password): string 
     {
         $hash = password_hash($password, PASSWORD_DEFAULT);
         return $hash;
     }
 

     /**
      * Check if password and passwordConfirm match
      * 
      * @access public
      * @package PhpTraining2\models\forms
      */
 
     public function checkPasswordConfirmation(): void 
     {
         if (!empty($_POST["passwordConfirm"]) && $_POST["password"] !== $_POST["passwordConfirm"]) {
             throw new FormPasswordsDontMatchException();
         }
     }
}