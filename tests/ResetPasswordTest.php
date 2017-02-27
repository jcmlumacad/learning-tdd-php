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
    }

    public function testViewPasswordReset()
    {
        $this->visit('/')
            ->see('Welcome')
            ->click('Login')
            ->seePageIs('/login')
            ->see('Login')
            ->click('Forgot Your Password?')
            ->seePageIs('/password/reset')
            ->see('Reset Password');
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

    public function testShouldReceiveEmail()
    {
        
    }
}
