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
        $this->view("pages/register", $data);
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
                show("hasEmptyFields"); // TODO
                $this->index($dataInSession);
            }

            if($_POST["password"] !== $_POST["passwordConfirm"]) {
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
            
            if(!$validated) {
                // TODO
            } else {
                show("success");
                $fullData = array_merge($data["notToValidate"], $validated, $data["password"]);
                show($fullData);
                $user = new User(...$fullData);
            }
        }
        $this->view("pages/register");
    }

    public function login() {
        $this->view("pages/login");
    }

    
}