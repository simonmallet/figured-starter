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

    public function testGivenAdminUserWhenDeleteArticleAndExistsThenSuccessful()
    {
        $article = factory(Article::class)->create();

        $user = factory(User::class)->create(['role' => User::ROLE_ADMIN]);
        $this->actingAs($user, 'api')->json('DELETE', route('api.articles.delete', ['articleId' => $article->id]))
            ->assertStatus(200);

        $this->getArticlesList()
            ->assertStatus(200)
            ->assertJsonCount(0, 'data');
    }

    public function testGivenAdminUserWhenDeleteArticleAndNotFoundThenReturnNotFound()
    {
        $user = factory(User::class)->create(['role' => User::ROLE_ADMIN]);
        $this->actingAs($user, 'api')->json('DELETE', route('api.articles.delete', ['articleId' => 'fakeId']))
            ->assertStatus(400);
    }

    public function testGivenRegularUserWhenDeleteArticleThenReturnError()
    {
        $article = factory(Article::class)->create();

        $user = factory(User::class)->create(['role' => User::ROLE_USER]);
        $this->actingAs($user, 'api')->json('DELETE', route('api.articles.delete', ['articleId' => $article->id]))
            ->assertStatus(403);
    }

    public function testGivenAnonymousUserWhenDeleteArticleThenReturnError()
    {
        $article = factory(Article::class)->create();

        $this->json('DELETE', route('api.articles.delete', ['articleId' => $article->id]))
            ->assertStatus(403);
    }

    private function getArticlesList()
    {
        return $this->json('GET', route('api.articles.list'));
    }
}
