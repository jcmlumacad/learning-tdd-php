<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ResetPasswordTest extends TestCase
{
    use DatabaseTransactions;

    public function __construct()
    {
        $this->name = 'John Doe';
        $this->email = 'john@doe.com';
        $this->password = '123456';
        $this->confirmPassword = '123456';
        $this->token = 'test123';
    }

    public function testViewForgotPassword()
    {
        $this->visit('/')
            ->see('Welcome')
            ->click('Login')
            ->seePageIs('/login')
            ->see('Login')
            ->click('Forgot Your Password?')
            ->seePageIs('/password/reset')
            ->see('Reset Password');
            //
    }

    public function testSendPasswordResetLink()
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
            ->click('Logout')
            ->seePageIs('/')
            ->see('Welcome')
            ->click('Login')
            ->seePageIs('/login')
            ->see('Login')
            ->click('Forgot Your Password?')
            ->seePageIs('/password/reset')
            ->see('Reset Password')
            ->type($this->email, 'email')
            ->press('Send Password Reset Link')
            ->seePageIs('/password/reset')
            ->see('We have e-mailed your password reset link!');
    }

    public function testResetPasswordWithoutToken()
    {
        $this->visit('/password/reset')
            ->see('Reset Password');
    }

    public function testResetPasswordWithWrongToken()
    {
        $this->visit('/password/reset/' . $this->token)
            ->see('Reset Password')
            ->type('test@test.com', 'email')
            ->type($this->password, 'password')
            ->type($this->confirmPassword, 'password_confirmation')
            ->press('Reset Password')
            ->seePageIs('/password/reset/' . $this->token)
            ->see('We can\'t find a user with that e-mail address.');
    }

    public function testResetPasswordWithCorrectToken()
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
            ->click('Logout')
            ->seePageIs('/')
            ->see('Welcome')
            ->click('Login')
            ->seePageIs('/login')
            ->see('Login')
            ->click('Forgot Your Password?')
            ->seePageIs('/password/reset')
            ->see('Reset Password')
            ->type($this->email, 'email')
            ->press('Send Password Reset Link')
            ->seePageIs('/password/reset')
            ->see('We have e-mailed your password reset link!');

        $data = DB::table('password_resets')->first();

        $this->visit('/password/reset/' . $data->token)
            ->see('Reset Password')
            ->type($data->email, 'email')
            ->type($this->password, 'password')
            ->type($this->confirmPassword, 'password_confirmation')
            ->press('Reset Password')
            ->seePageIs('/home')
            ->see('Dashboard');
    }
}
