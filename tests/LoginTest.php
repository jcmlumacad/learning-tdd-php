<?php

use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{
    use DatabaseTransactions;

    public function __construct()
    {
        $this->name = 'John Doe';
        $this->email = 'john@doe.com';
        $this->password = '123456';
    }

    public function testLoginWithCorrectCredentials()
    {
        factory(User::class)->create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password)
        ]);

        $this->visit('/login')
            ->see('Login')
            ->type($this->email, 'email')
            ->type($this->password, 'password')
            ->check('remember')
            ->press('Login')
            ->seePageIs('/home')
            ->see('Dashboard')
            ->seeIsAuthenticated();
    }

    public function testLoginWithWrongCredentials()
    {
        $this->visit('/login')
            ->see('Login')
            ->type($this->email, 'email')
            ->type('invalid-password', 'password')
            ->check('remember')
            ->press('Login')
            ->seePageIs('/login')
            ->see('These credentials do not match our records')
            ->dontSeeIsAuthenticated();
    }
}
