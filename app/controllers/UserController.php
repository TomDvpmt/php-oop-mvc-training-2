<?php

namespace PhpTraining2\controllers;

use PhpTraining2\core\Controller;
use PhpTraining2\models\Form;
use PhpTraining2\models\User;

require_once MODELS_DIR . "User.php";
require_once MODELS_DIR . "Form.php";

class UserController {
    use Controller;


    /**
     * Default method of the controller
     * 
     * @access public
     * @package PhpTraining2\controllers
     */

    public function index(array $data): void {
        //
    }

    /**
     * Register a new user
     * 
     * @access public
     * @package PhpTraining2\controllers
     */

    public function register() {
        if(isset($_POST["submit"])) { 
            $form = new Form();
            $form->setRequired($form::REGISTER_REQUIRED);
            $dataInSession = $form->setFormDataInSession();
            
            if($form->hasEmptyFields()) {
                $form->setEmptyFieldsError();
                $this->index($dataInSession);
            }

            if(!empty($_POST["passwordConfirm"]) && $_POST["password"] !== $_POST["passwordConfirm"]) {
                $form->addValidationError(("passwordsDontMatch"));
                $this->index($dataInSession);
            }

            $data = [ // beware of properties order, must match class User constructor
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
                $this->view("pages/register", ["formData" => $inputData, "validationErrors" => $validationErrors]);
            } else {
                $fullData = array_merge($data["notToValidate"], $validated, $data["password"]);
                $user = new User(...$fullData);
                
                if(!empty($user->findOne())) {
                    $form->addValidationError("emailAlreadyUsed");
                    $validationErrors = $form->getValidationErrors();
                    $this->view("pages/register", ["formData" => $inputData, "validationErrors" => $validationErrors]);
                } else {
                    $user->createOne();
                };
            }
        }
        $this->view("pages/register");
    }

    public function login() {
        $this->view("pages/login");
    }

    
}