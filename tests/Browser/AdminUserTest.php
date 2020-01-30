<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

/**
 * IMPORTANT: All skipped tests are due to a network problem between the selenium / web / db...
 * The user & article information gets saved inside the test databases but for some reason
 * when selenium runs the tests the articles & users cannot be found...
 */
class AdminUserTest extends DuskTestCase
{
    use DatabaseMigrations;
    const ADMIN_PWD = 'password';

    public function testGivenValidCredentialsWhenSignInThenRedirectToAdminPage()
    {
        $this->markTestSkipped('');
        $user = factory(User::class)->create(['role' => User::ROLE_ADMIN]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                ->type('input#email', $user->email)
                ->type('input#password', self::ADMIN_PWD)
                ->press('Sign in')
                ->assertPathIs('/admin');
        });
    }

    /*
    public function testGivenInvalidCredentialsWhenSignInThenErrorDisplayed()
    {
        //
    }*/
}
