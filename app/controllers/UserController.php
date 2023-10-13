<?php

namespace PhpTraining2\controllers;

use PhpTraining2\core\Controller;
use PhpTraining2\controllers\ControllerInterface;
use PhpTraining2\models\User;
use PhpTraining2\models\UserForm;

class UserController implements ControllerInterface {
    use Controller;

    public function index(): void {
        $user = new User();
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
            $form = new UserForm();
            $form->setRequired($form::REGISTER_REQUIRED);
            $dataInSession = $form->setFormDataInSession($form::REGISTER_TO_VALIDATE);
            
            if($form->hasEmptyFields()) {
                $form->setEmptyFieldsError();
                $this->index($dataInSession);
            }

            if(!empty($_POST["passwordConfirm"]) && $_POST["password"] !== $_POST["passwordConfirm"]) {
                $form->addValidationError(("passwordsDontMatch"));
                $this->index($dataInSession);
            }

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
                    "password" => password_hash($_POST["password"], PASSWORD_DEFAULT)
                ]
            ];
            
            $validated = $form->validate($data["toValidate"]);

            $inputData = [
                "email" => $_POST["email"],
                "firstName" => $_POST["firstName"],
                "lastName" => $_POST["lastName"],
                "password" => $_POST["password"],
                "passwordConfirm" => $_POST["passwordConfirm"],
            ];
            
            if(!$validated) {
                $validationErrors = $form->getValidationErrors();
                $this->view("pages/signup", ["formData" => $inputData, "validationErrors" => $validationErrors]);
            } else {
                $fullData = array_merge($data["notToValidate"], $validated, $data["password"]);
                $user = new User(...$fullData);
                
                if(!empty($user->findOne("email = :email"))) {
                    $form->addValidationError("emailAlreadyUsed");
                    $validationErrors = $form->getValidationErrors();
                    $this->view("pages/signup", ["formData" => $inputData, "validationErrors" => $validationErrors]);
                } else {
                    $user->createOne();
                };
            }
        }
        $this->view("pages/signup");
    }

    public function signin() {
        $this->view("pages/signin");
    }

    
}