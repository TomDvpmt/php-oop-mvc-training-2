<?php

namespace PhpTraining2\controllers;

use PhpTraining2\core\Controller;
use PhpTraining2\controllers\ControllerInterface;
use PhpTraining2\models\forms\UserFormSignUp;
use PhpTraining2\models\users\Customer;

class UserController implements ControllerInterface {
    use Controller;

    public function index(): void {
        // $user = new User();
        $this->executeMethodIfExists();
    }


    /**
     * Sign a new user up
     * 
     * @access public
     * @package PhpTraining2\controllers
     */

    public function signup() {
        if(isset($_POST["submit"])) { 
            $form = new UserFormSignUp();
            $form->setRequired($form::SIGNUP_REQUIRED);
            $dataInSession = $form->setFormDataInSession($form::SIGNUP_TO_VALIDATE);
            
            if($form->hasEmptyFields()) {
                $form->setEmptyFieldsError();
                $this->index($dataInSession);
            }

            if(!empty($_POST["passwordConfirm"]) && $_POST["password"] !== $_POST["passwordConfirm"]) {
                $form->addValidationError(("passwordsDontMatch"));
                $this->index($dataInSession);
            }

            $tempData = $this->getTempSignUpData();
            $validated = $form->validate($tempData["toValidate"]);

            if(!$validated) {
                $this->showFormWithErrors($form, "signUp");
            } else {
                $finalSignUpData = array_merge($tempData["notToValidate"], $validated, $tempData["password"]);
                $customer = new Customer(...$finalSignUpData);
                
                if(!empty($customer->findOne("email = :email"))) {
                    $form->addValidationError("emailAlreadyUsed");
                    $this->showFormWithErrors($form, "signUp");
                } else {
                    $customer->createOne();
                };
            }
        }
        $this->view("pages/signup");
    }

    /**
     * Sign a user in
     * 
     * @access public
     * @package PhpTraining2\controllers
     */

    public function signin() {
        // TODO
        $this->view("pages/signin");
    }


    /**
     * Get signup data
     * 
     * @access private
     * @package PhpTraining2\controllers
     * @return array
     */

    private function getTempSignUpData(): array {
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
            ],
            "password" => [
                "password" => $this->getHashedPassword($_POST["password"])
            ]
        ];
        return $data;
    }  


    /**
     * Get hashed password
     * 
     * @access private
     * @package PhpTraining2\controllers
     * @param string $password The password entered by the user
     * @return string
     */

     private function getHashedPassword(string $password): string {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        return $hash;
    }
}