<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function () {
    Route::post('register', 'AuthController@register')->name('api.register');
    Route::post('login', 'AuthController@login')->name('api.authenticate');
    Route::get('refresh', 'AuthController@refresh');
    Route::group(['middleware' => 'auth:api'], function(){
        Route::get('user', 'AuthController@user');
        Route::post('logout', 'AuthController@logout');
    });
});

Route::get('article', 'ArticleController@index')->name('api.articles.list');
Route::get('article/{articleId}', 'ArticleController@show')->name('api.articles.show');

Route::group(['middleware' => 'auth:api'], function(){
    Route::post('article', 'ArticleController@store')->middleware('isAdmin')->name('api.articles.post');
    Route::match(['put', 'patch'], 'article/{articleId}', 'ArticleController@update')->middleware('isAdmin')->name('api.articles.update');
    Route::delete('article/{articleId}', 'ArticleController@destroy')->middleware('isAdmin')->name('api.articles.delete');
});
