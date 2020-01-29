<?php

namespace Tests\Unit\Http\Controllers;

use App\Models\Article;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    public function testGivenNoArticlesWhenArticleIsCalledThenEmptyDatasetReturned()
    {
        $response = $this->json('GET', '/api/article');
        $response
            ->assertStatus(200)
            ->assertJsonCount(0, 'data');
    }

    public function testGivenOneArticleWhenArticleIsCalledThenOneDatasetReturned()
    {
        factory(Article::class)->create();

        $response = $this->json('GET', '/api/article');
        $response
            ->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }
}
