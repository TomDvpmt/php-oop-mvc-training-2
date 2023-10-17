<?php

use PhpTraining2\exceptions\FormEmailException;
use PhpTraining2\exceptions\FormPasswordLengthException;
use PhpTraining2\models\forms\UserFormSignIn;
use PHPUnit\Framework\TestCase;

/**
 * @testdox models\forms\UserFormSignIn
*/

class UserFormSignInTest extends TestCase {

    /**
     * @testdox Invalid email format throws EmailException
     */

    public function testInvalidEmailThrowsEmailException() {
        $this->expectException(FormEmailException::class);
        $input = ["type" => "email", "value" => "WRONG", "name" => "email"];
        $form = new UserFormSignIn();
        $form->validate([$input]);
    }

    /**
     * @testdox Password shorter than 8 characters throws PasswordLengthException
     */

    public function testShortPasswordThrowsPasswordLengthException() {
        $this->expectException(FormPasswordLengthException::class);
        $input = ["type" => "password", "value" => "WRONG", "name" => "password"];
        $form = new UserFormSignIn();
        $form->validate([$input]);
    }
}