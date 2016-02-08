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

$app->get('/', function () use ($app) {
    return $app->version();
});


$app->group(['prefix' => 'v1'], function () use ($app) {

    $app->get('/categories', 'App\Http\Controllers\CategoriesController@index');
    $app->get('/categories/{id}', 'App\Http\Controllers\CategoriesController@show');
    $app->get('/posts/popular', 'App\Http\Controllers\PostsController@index');
    $app->get('/posts/{id}', 'App\Http\Controllers\PostsController@show');

    $app->post('/handset/register', 'App\Http\Controllers\HandsetController@registerHandset');

});




/**
 * Routes for resource task
 */
$app->get('task', 'TasksController@all');
$app->get('task/{id}', 'TasksController@get');
$app->post('task', 'TasksController@add');
$app->put('task/{id}', 'TasksController@put');
$app->delete('task/{id}', 'TasksController@remove');
