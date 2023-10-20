<?php

namespace PhpTraining2\controllers;

use Exception;
use PhpTraining2\core\Controller;
use PhpTraining2\core\ControllerInterface;
use PhpTraining2\exceptions\FormPropertyAlreadyExistsException;
use PhpTraining2\exceptions\UserGetDataException;
use PhpTraining2\exceptions\UserInvalidCredentialsException;
use PhpTraining2\models\forms\UserFormSignIn;
use PhpTraining2\models\forms\UserFormSignUp;
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
                $this->view("pages/signup", [...$_POST, "error" => $e->getMessage()]);
                return;
            }

            /* User registering */
            $finalSignUpData = array_merge($tempData["notToValidate"], $validated);
            $hashedPassword = $form->getHashedPassword($_POST["password"]);
            $finalSignUpData["password"] = $hashedPassword;
            
            $user = new User(...$finalSignUpData);

            try {
                if($user->alreadyExists()) {
                    throw new FormPropertyAlreadyExistsException("email address");
                };
                $user->createOne();
            } catch (Exception $e) {
                $this->view("pages/signup", [...$_POST, "error" => $e->getMessage()]);
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
                $this->view("pages/signin", [...$_POST, "error" => $e->getMessage()]);
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
                $user = (new User())->getOne("email", $sanitizedEmail);
                if(!$user) {
                    throw new UserInvalidCredentialsException();
                }
                $isPasswordMatch = password_verify($_POST["password"], $user["password"]);
                if(!$isPasswordMatch) {
                    throw new UserInvalidCredentialsException();
                }
            } catch (Exception $e) {
                $this->view("pages/signin", [...$_POST, "error" => $e->getMessage()]);
                // show("exception");
                return;
            }

            /* Sign in */
            $_SESSION["userId"] = $user["id"];
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

    /**
     * Get user info
     * 
     * @access private
     * @package PhpTraining2\controllers
     * @return array
     */

    private function getUserInfo(): array {
        $user = (new User())->getOneById();
        if(!$user) throw new UserGetDataException();
        return $user;
    }

    /**
     * Check if user is signed in
     * 
     * @access public
     * @package PhpTraining2\controllers
     */

    public function isUserSignedIn(): bool {
        return  isset($_SESSION["userId"]);
    }


    /**
     * Display the user info view
     * 
     * @access public
     * @package PhpTraining2\controllers
     */

    public function info(): void {
        try {
            $userFullInfo = $this->getUserInfo();
        } catch (Exception $e) {
            $this->view("pages/user-info", ["error" => PRODUCTION ? "Unable to get user data." : $e->getMessage()]);
            return;
        }
        $propertiesToShow = ["email", "first_name", "last_name"];
        $userInfo = array_filter($userFullInfo, fn($key) => in_array($key, $propertiesToShow), ARRAY_FILTER_USE_KEY);
        $this->view("pages/user-info", $userInfo);
    }


    /**
     * Display the user orders view
     * 
     * @access public
     * @package PhpTraining2\controllers
     */

    public function orders(): void {
        $this->view("pages/user-orders");
    }
}