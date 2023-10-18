<?php

namespace PhpTraining2\controllers;

use Exception;
use PhpTraining2\core\Controller;
use PhpTraining2\core\ControllerInterface;
use PhpTraining2\exceptions\FormPropertyAlreadyExistsException;
use PhpTraining2\models\forms\UserFormSignUp;
use PhpTraining2\models\users\Customer;
use PhpTraining2\models\users\User;

class UserController implements ControllerInterface {
    use Controller;

    public function index(): void 
    {
        // $user = new User();
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
        // TODO
        $this->view("pages/signin");
    }
}