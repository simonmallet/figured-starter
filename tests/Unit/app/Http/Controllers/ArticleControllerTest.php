<?php

namespace Tests\Unit\Http\Controllers;

use App\Models\Article;
use App\Models\User;
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

    public function testGivenAdminUserWhenCreateArticleThenSuccessful()
    {
        $user = factory(User::class)->create(['role' => User::ROLE_ADMIN]);
        $this->actingAs($user, 'api')->json('POST', route('api.articles.post'))
            ->assertStatus(201);

        $this->getArticlesList()
            ->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    public function testGivenRegularUserWhenCreateArticleThenReturnError()
    {
        $user = factory(User::class)->create(['role' => User::ROLE_USER]);
        $this->actingAs($user, 'api')->json('POST', route('api.articles.post'))
            ->assertStatus(403);

        $this->getArticlesList()
            ->assertStatus(200)
            ->assertJsonCount(0, 'data');
    }

    public function testGivenAnonymousUserWhenCreateArticleThenReturnError()
    {
        $this->json('POST', route('api.articles.post'))
            ->assertStatus(403);
    }

    public function testDeleteExistingArticle()
    {

    }

    public function testDeleteArticleNotFound()
    {

    }
}
