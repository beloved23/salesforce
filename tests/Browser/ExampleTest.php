<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\User;

class ExampleTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Login to Airtel Sales Force System');
        });
    }
    public function testUserLogin()
    {
        $user = factory(User::class)->create([
            'email' => 'adekunle@nanotech.com',
            'auuid'=>'1234567'
        ]);

        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                    ->type('auuid', $user->auuid)
                    ->type('password', 'secret')
                    ->press('Sign in!')
                    ->assertPathIs('/salesforce/dashboard');
        });
    }
}
