<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegisterTest extends TestCase
{
    use DatabaseTransactions;

    public function __construct()
    {
        $this->name = 'John Doe';
        $this->email = 'john@doe.com';
        $this->password = '123456';
        $this->confirmPassword = '123456';
    }

    public function testRegisterOnlyName()
    {
        $this->visit('/register')
            ->see('Register')
            ->type($this->name, 'name')
            ->press('Register')
            ->seePageIs('/register')
            ->see('The email field is required.')
            ->see('The password field is required.');
    }

    public function testRegisterOnlyEmail()
    {
        $this->visit('/register')
            ->see('Register')
            ->type($this->email, 'email')
            ->press('Register')
            ->seePageIs('/register')
            ->see('The name field is required.')
            ->see('The password field is required.');
    }

    public function testRegisterOnlyPassword()
    {
        $this->visit('/register')
            ->see('Register')
            ->type($this->password, 'password')
            ->press('Register')
            ->seePageIs('/register')
            ->see('The name field is required.')
            ->see('The email field is required.')
            ->see('The password confirmation does not match.');
    }

    public function testRegisterOnlyConfirmationPassword()
    {
        $this->visit('/register')
            ->see('Register')
            ->type($this->confirmPassword, 'password_confirmation')
            ->press('Register')
            ->seePageIs('/register')
            ->see('The name field is required.')
            ->see('The email field is required.')
            ->see('The password field is required.');
    }

    public function testRegisterOnlyNameAndEmail()
    {
        $this->visit('/register')
            ->see('Register')
            ->type($this->name, 'name')
            ->type($this->email, 'email')
            ->press('Register')
            ->seePageIs('/register')
            ->see('The password field is required.');
    }

    public function testRegisterOnlyNameAndPassword()
    {
        $this->visit('/register')
            ->see('Register')
            ->type($this->name, 'name')
            ->type($this->password, 'password')
            ->press('Register')
            ->seePageIs('/register')
            ->see('The email field is required.')
            ->see('The password confirmation does not match.');
    }

    public function testRegisterOnlyNameAndConfirmationPassword()
    {
        $this->visit('/register')
            ->see('Register')
            ->type($this->name, 'name')
            ->type($this->confirmPassword, 'password_confirmation')
            ->press('Register')
            ->seePageIs('/register')
            ->see('The email field is required.')
            ->see('The password field is required.');
    }

    public function testRegisterOnlyEmailAndPassword()
    {
        $this->visit('/register')
            ->see('Register')
            ->type($this->email, 'email')
            ->type($this->password, 'password')
            ->press('Register')
            ->seePageIs('/register')
            ->see('The name field is required.')
            ->see('The password confirmation does not match.');
    }

    public function testRegisterOnlyEmailAndConfirmationPassword()
    {
        $this->visit('/register')
            ->see('Register')
            ->type($this->email, 'email')
            ->type($this->confirmPassword, 'password_confirmation')
            ->press('Register')
            ->seePageIs('/register')
            ->see('The name field is required.')
            ->see('The password field is required.');
    }

    public function testRegisterOnlyPasswordAndConfirmationPassword()
    {
        $this->visit('/register')
            ->see('Register')
            ->type($this->password, 'password')
            ->type($this->confirmPassword, 'password_confirmation')
            ->press('Register')
            ->seePageIs('/register')
            ->see('The name field is required.')
            ->see('The email field is required.');
    }

    public function testRegisterAllExceptName()
    {
        $this->visit('/register')
            ->see('Register')
            ->type($this->email, 'email')
            ->type($this->password, 'password')
            ->type($this->confirmPassword, 'password_confirmation')
            ->press('Register')
            ->seePageIs('/register')
            ->see('The name field is required.');
    }

    public function testRegisterAllExceptEmail()
    {
        $this->visit('/register')
            ->see('Register')
            ->type($this->name, 'name')
            ->type($this->password, 'password')
            ->type($this->confirmPassword, 'password_confirmation')
            ->press('Register')
            ->seePageIs('/register')
            ->see('The email field is required.');
    }

    public function testRegisterAllExceptPassword()
    {
        $this->visit('/register')
            ->see('Register')
            ->type($this->name, 'name')
            ->type($this->email, 'email')
            ->type($this->confirmPassword, 'password_confirmation')
            ->press('Register')
            ->seePageIs('/register')
            ->see('The password field is required.');
    }

    public function testRegisterAllExceptConfirmationPassword()
    {
        $this->visit('/register')
            ->see('Register')
            ->type($this->name, 'name')
            ->type($this->email, 'email')
            ->type($this->password, 'password')
            ->press('Register')
            ->seePageIs('/register')
            ->see('The password confirmation does not match.');
    }

    public function testRegisterAll()
    {
        $this->visit('/register')
            ->see('Register')
            ->type($this->name, 'name')
            ->type($this->email, 'email')
            ->type($this->password, 'password')
            ->type($this->confirmPassword, 'password_confirmation')
            ->press('Register')
            ->seePageIs('/home')
            ->see('Dashboard')
            ->seeIsAuthenticated();
    }

    public function testRegisterWithoutInputs()
    {
        $this->visit('/register')
            ->see('Register')
            ->press('Register')
            ->seePageIs('/register')
            ->see('The name field is required.')
            ->see('The email field is required.')
            ->see('The password field is required.');
    }

    public function testPasswordMustNotMatchToConfirmationPassword()
    {
        $this->visit('/register')
            ->see('Register')
            ->type($this->password, 'password')
            ->type('qwerty', 'password_confirmation')
            ->press('Register')
            ->seePageIs('/register')
            ->see('The password confirmation does not match.');
    }
}
