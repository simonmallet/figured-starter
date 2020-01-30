<?php

namespace Tests\Browser;

use App\Models\Article;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

/**
 * IMPORTANT: All skipped tests are due to a network problem between the selenium / web / db...
 * The user & article information gets saved inside the test databases but for some reason
 * when selenium runs the tests the articles & users cannot be found...
 */
class BasicHomePageTest extends DuskTestCase
{
    const NO_ARTICLE_MESSAGE = 'Looks like there is no post at the moment';

    public function testLoginLinkIsPresent()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Login');
        });
    }

    public function testWhenNoArticleThenDefaultMessageIsDisplayed()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee(self::NO_ARTICLE_MESSAGE);
        });
    }

    public function testWhenArticleThenDefaultMessageIsHidden()
    {
        $this->markTestSkipped();
        factory(Article::class)->create();

        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertDontSee(self::NO_ARTICLE_MESSAGE);
        });
    }
}
