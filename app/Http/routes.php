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

    $api->get('/', 'App\Http\Controllers\DocsController@index');


    $api->post('/handset/register', 'App\Http\Controllers\HandsetController@registerHandset');
    $api->get('/categories/', 'App\Http\Controllers\CategoriesController@index');
    $api->get('/categories/{id}', 'App\Http\Controllers\CategoriesController@show');
    $api->get('/posts/popular', 'App\Http\Controllers\PostsController@index');
    $api->get('/posts/{id}', 'App\Http\Controllers\PostsController@show');
    $api->post('/posts/new', 'App\Http\Controllers\PostsController@store');
});



//
//
//$app->group(['prefix' => 'v1'], function () use ($app) {
//
//    $app->get('/categories', 'App\Http\Controllers\CategoriesController@index');
//    $app->get('/categories/{id}', 'App\Http\Controllers\CategoriesController@show');
//    $app->get('/posts/popular', 'App\Http\Controllers\PostsController@index');
//    $app->get('/posts/{id}', 'App\Http\Controllers\PostsController@show');
//    $app->post('/handset/register', 'App\Http\Controllers\HandsetController@registerHandset');
//    $app->post('/posts/new', 'App\Http\Controllers\PostsController@store');
//});
//
