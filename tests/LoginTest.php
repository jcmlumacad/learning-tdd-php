<?php

use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{
    use DatabaseTransactions;

    public function testLoginWithCorrectCredentials()
    {
        factory(User::class)->create([
            'name' => 'John Doe',
            'email' => 'john@doe.com',
            'password' => bcrypt('123456')
        ]);

        $this->visit('/login')
            ->see('Login')
            ->type('john@doe.com', 'email')
            ->type('123456', 'password')
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
            ->type('john@doe.com', 'email')
            ->type('invalid-password', 'password')
            ->check('remember')
            ->press('Login')
            ->seePageIs('/login')
            ->see('These credentials do not match our records')
            ->dontSeeIsAuthenticated();
    }
}
