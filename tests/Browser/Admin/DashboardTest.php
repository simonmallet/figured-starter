<?php

namespace Tests\Browser\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

/**
 * IMPORTANT: All skipped tests are due to a network problem between the selenium / web / db...
 * The user & article information gets saved inside the test databases but for some reason
 * when selenium runs the tests the articles & users cannot be found...
 */
class DashboardTest extends DuskTestCase
{
    use DatabaseMigrations;
    const ADMIN_PWD = 'password';

    public function testGivenNoArticleThenDefaultMessageDisplayed()
    {
        $this->markTestSkipped('');
    }


    public function testGivenAnArticleThenArticleIsDisplayed()
    {
        $this->markTestSkipped();
    }

    public function testGivenAnArticleThenUpdateLinkIsPresent()
    {
        $this->markTestSkipped();
    }

    public function testGivenAnArticleThenDeleteLinkIsPresent()
    {
        $this->markTestSkipped();
    }
}
