<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

    $api->post('/handset/register', 'App\Http\Controllers\v1\HandsetController@registerHandset');

    $api->get('/handset/settings', 'App\Http\Controllers\v1\HandsetController@getAppSpecificSettings');
    $api->post('/handset/settings', 'App\Http\Controllers\v1\HandsetController@postAppSpecificSettings');

    $api->post('/user/register', 'App\Http\Controllers\v1\AuthController@createAppUser');

    $api->get('/categories', 'App\Http\Controllers\v1\CategoriesController@getAllCategories');
    $api->get('/categories/{id}', 'App\Http\Controllers\v1\CategoriesController@getCategoryById');
    $api->get('/categories/{id}/posts', 'App\Http\Controllers\v1\CategoriesController@getCategoryWithPosts');

    $api->get('/topics', 'App\Http\Controllers\v1\TagsController@getAllTags');
    $api->get('/topics/{id}', 'App\Http\Controllers\v1\TagsController@getTagById');
    $api->get('/topics/{id}/posts', 'App\Http\Controllers\v1\TagsController@getTagWithPosts');

    $api->get('/posts/featured', 'App\Http\Controllers\v1\PostsController@getTopStories');
    $api->get('/posts/popular', 'App\Http\Controllers\v1\PostsController@getPopularPosts');
    $api->get('/posts/latest', 'App\Http\Controllers\v1\PostsController@getToDaysPosts');

    $api->get('/posts/{id}', 'App\Http\Controllers\v1\PostsController@getPostById');
    $api->post('/posts/new', 'App\Http\Controllers\v1\PostsController@store');
});

$app->get('/', 'v1\DocsController@index');