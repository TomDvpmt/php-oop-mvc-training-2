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

    public function index(): void {
        $this->view("pages/register");
    }

    public function register() {
        if(isset($_POST["submit"])) {            
            $data = [
                "id" => 0, 
                "firstName" => $_POST["firstName"], 
                "lastName" => $_POST["lastName"], 
                "email" => $_POST["email"], 
                "password" => $_POST["password"], 
                "passwordConfirm" => $_POST["passwordConfirm"], 
                "isAdmin" => 0
            ];
            $required = ["email", "password", "passwordConfirm"];
            
            $form = new Form($data);
            if($form->hasEmptyFields($required)) {
                $form->addValidationError("hasEmptyFields");
            }

            

            // $user = new User(...$validatedData);
            // show($user);
        }
        $this->view("pages/register");
    }

    public function login() {
        $this->view("pages/login");
    }

    
}