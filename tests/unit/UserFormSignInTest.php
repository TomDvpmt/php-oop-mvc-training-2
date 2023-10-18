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
        $input = ["type" => "email", "value" => "WRONG", "name" => "email"]; // TODO : other wrong values
        $form = new UserFormSignIn();
        $form->validate([$input]);
    }

    /**
     * @testdox Password shorter than 8 characters throws PasswordLengthException
     */

    public function testShortPasswordThrowsPasswordLengthException() {
        $this->expectException(FormPasswordLengthException::class);
        $form = new UserFormSignIn();
        $minLength = $form::PASSWORD_MIN_LENGTH;
        $length = random_int(1, $minLength);
        
        // $randomString = getRandomString($length); // TODO : put utils in Utils class and call its getRandomString method here
        $chars = implode(array_merge(range("a", "z"), range("A", "Z"), range(0, 9)));
        $shuffled = str_shuffle($chars);
        $randomString = substr($shuffled, 0, $length);

        $input = ["type" => "password", "value" => $randomString, "name" => "password"]; 
        $form->validate([$input]); // TODO : 10 tries
    }
}