<?php

namespace Tests\Unit\Http\Controllers;

use App\Models\Article;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    public function testGivenNoArticlesWhenArticleIsCalledThenEmptyDatasetReturned()
    {
        $this->getArticlesList()
            ->assertStatus(200)
            ->assertJsonCount(0, 'data');
    }

    public function testGivenOneArticleWhenArticleIsCalledThenOneDatasetReturned()
    {
        factory(Article::class)->create();

        $this->getArticlesList()
            ->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    public function testGivenTwoArticlesWhenArticleIsCalledThenTwoDatasetReturned()
    {
        factory(Article::class, 2)->create();

        $this->getArticlesList()
            ->assertStatus(200)
            ->assertJsonCount(2, 'data');
    }

    private function getArticlesList()
    {
        return $this->json('GET', route('api.articles.list'));
    }

    public function testCreateArticle()
    {

    }

    public function testDeleteExistingArticle()
    {

    }

    public function testDeleteArticleNotFound()
    {

    }
}
