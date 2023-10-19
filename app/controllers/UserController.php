<?php

namespace PhpTraining2\controllers;

use Exception;
use PhpTraining2\core\Controller;
use PhpTraining2\core\ControllerInterface;
use PhpTraining2\exceptions\FormPropertyAlreadyExistsException;
use PhpTraining2\exceptions\UserInvalidCredentialsException;
use PhpTraining2\models\forms\UserFormSignIn;
use PhpTraining2\models\forms\UserFormSignUp;
use PhpTraining2\models\users\Customer;
use PhpTraining2\models\users\User;

class UserController implements ControllerInterface {
    use Controller;

    public function index(): void 
    {
        $this->executeMethodIfExists();
    }


    /**
     * Sign a new user up
     * 
     * @access public
     * @package PhpTraining2\controllers
     */

    public function signup() 
    {
        if($this->isUserSignedIn()) {
            header("Location:" . ROOT);
        }
        
        if (isset($_POST["submit"])) { 
            $form = new UserFormSignUp();
            
            /* Input validation */
            $form->setRequired($form::SIGNUP_REQUIRED);
            try {
                $form->checkEmptyFields();
                $form->checkPasswordConfirmation();
                $tempData = $form->getTempSignUpData();
                $validated = $form->validate($tempData["toValidate"]);
            } catch (Exception $e) {
                $this->view("pages/signup", $_POST, $e->getMessage());
                return;
            }

            /* User registering (default role : Customer) */
            $finalSignUpData = array_merge($tempData["notToValidate"], $validated);
            $hashedPassword = $form->getHashedPassword($_POST["password"]);
            $finalSignUpData["password"] = $hashedPassword;
            
            $customer = new Customer(...$finalSignUpData);

            try {
                if($customer->alreadyExists()) {
                    throw new FormPropertyAlreadyExistsException("email address");
                };
                $customer->createOne();
            } catch (Exception $e) {
                $this->view("pages/signup", $_POST, $e->getMessage());
                return;
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

    public function signin() 
    {
        if($this->isUserSignedIn()) {
            header("Location:" . ROOT);
        }
        
        if (isset($_POST["submit"])) { 
            $form = new UserFormSignIn();
            
            /* Input validation */
            $form->setRequired($form::SIGNIN_REQUIRED);
            try {
                $form->checkEmptyFields();
            } catch (Exception $e) {
                $this->view("pages/signin", $_POST, $e->getMessage());
                return;
            }

            /* Check credentials */
            try {
                $emailInput = [
                    "type" => "email",
                    "name" => "email",
                    "value" => $_POST["email"]
                ];
                $sanitizedEmail = $form->sanitizeInput($emailInput)["value"]; // TODO : test email sanitation
                $customer = (new Customer())->getOne("email", $sanitizedEmail);
                if(!$customer) {
                    throw new UserInvalidCredentialsException();
                }
                $isPasswordMatch = password_verify($_POST["password"], $customer["password"]);
                if(!$isPasswordMatch) {
                    throw new UserInvalidCredentialsException();
                }
            } catch (Exception $e) {
                $this->view("pages/signin", $_POST, $e->getMessage());
                return;
            }

            /* Sign in */
            $_SESSION["userId"] = $customer["id"];
            header("Location:" . ROOT);
        }
        $this->view("pages/signin");
    }

    /**
     * Sign the user out
     * 
     * @access public
     * @package PhpTraining2\controllers
     */

    public function signOut() 
    {
        unset($_SESSION["userId"]);
        header("Location:" . ROOT);
    }


    private function isUserSignedIn(): bool {
        return  isset($_SESSION["userId"]);
    }
}