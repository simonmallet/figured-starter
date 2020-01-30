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

    public function testGivenOneValidArticleIdWhenGetArticleThenReturnArticle()
    {
        $article = factory(Article::class)->create();

        $this->getArticle($article->_id)
            ->assertStatus(200)
            ->assertJsonFragment(['title' => $article->title]);
    }

    public function testGivenOneInvalidArticleIdWhenGetArticleThenReturnNotFound()
    {
        factory(Article::class)->create();

        $this->getArticle('badId')
            ->assertStatus(400);
    }

    public function testGivenAdminUserWhenCreateArticleAndValidFieldsThenSuccessful()
    {
        $user = factory(User::class)->create(['role' => User::ROLE_ADMIN]);
        $this->actingAs($user, 'api')->json('POST', route('api.articles.post'), ['title' => 'abc', 'body' => 'def'])
            ->assertStatus(201);

        $this->getArticlesList()
            ->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    public function testGivenAdminUserWhenCreateArticleAndInvalidFieldsThenErrorThrown()
    {
        $user = factory(User::class)->create(['role' => User::ROLE_ADMIN]);
        $this->actingAs($user, 'api')->json('POST', route('api.articles.post'), ['title' => '', 'body' => 'def'])
            ->assertStatus(422);
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

    public function testGivenAdminUserWhenUpdateArticleAndValidFieldsThenSuccessful()
    {
        $user = factory(User::class)->create(['role' => User::ROLE_ADMIN]);
        $article = factory(Article::class)->create();

        $this->actingAs($user, 'api')->json(
            'PUT',
            route('api.articles.update', ['articleId' => $article->id]),
            ['title' => 'ok!', 'body' => 'ok!'])
            ->assertStatus(200);
    }

    public function testGivenAdminUserWhenUpdateArticleAndInvalidFieldsThenErrorThrown()
    {
        $user = factory(User::class)->create(['role' => User::ROLE_ADMIN]);
        $article = factory(Article::class)->create();

        $this->actingAs($user, 'api')->json(
            'PUT',
            route('api.articles.update', ['articleId' => $article->id]),
            ['title' => '', 'body' => 'ok!'])
            ->assertStatus(422);
    }

    public function testGivenRegularUserWhenUpdateArticleThenErrorThrown()
    {
        $user = factory(User::class)->create(['role' => User::ROLE_USER]);
        $article = factory(Article::class)->create();

        $this->actingAs($user, 'api')->json('PUT',
            route('api.articles.update', ['articleId' => $article->id]),
            ['title' => 'ok!', 'body' => 'ok!'])
            ->assertStatus(403);
    }

    public function testGivenAnonymousUserWhenUpdateArticleThenErrorThrown()
    {
        $article = factory(Article::class)->create();

        $this->json('PUT',
            route('api.articles.update', ['articleId' => $article->id]),
            ['title' => 'ok!', 'body' => 'ok!'])
            ->assertStatus(403);
    }

    private function getArticlesList()
    {
        return $this->json('GET', route('api.articles.list'));
    }

    private function getArticle($articleId)
    {
        return $this->json('GET', route('api.articles.show', ['articleId' => $articleId]));
    }
}
