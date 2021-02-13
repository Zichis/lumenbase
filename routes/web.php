<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['middleware' => ['auth', 'admin']], function () use ($router) {
    $router->group(['prefix' => 'users'], function () use ($router) {
        $router->get('/', 'UserController@index');
        $router->get('{id}', 'UserController@show');
        $router->put('{id}', 'UserController@update');
        $router->post('/', 'UserController@create');
        $router->delete('{id}', 'UserController@destroy');
    });
});

$router->get('profile', [
    'middleware' => 'auth',
    'uses' => 'ProfileController@index'
]);

$router->get('users/count', 'UserController@count');
$router->get('current-user', [
    'middleware' => 'auth',
    'uses' => 'UserController@current'
]);
$router->post('onboard', [
    'uses' => 'UserController@onboard'
]);
$router->post('login', 'LoginController@login');
$router->get('logout', 'UserController@logout');
