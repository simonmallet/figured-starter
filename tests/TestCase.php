<?php

namespace Tests;

use App\Models\Article;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->loadEnvironmentFrom('.env.testing');

        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        return $app;
    }

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate:fresh');
    }

    public function tearDown(): void
    {
        // @todo: A more generic way to flush the test MongoDB?
        Article::truncate();
        parent::tearDown();
    }
}
