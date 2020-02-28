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

// $router->get('/', function () use ($router) {
//     return $router->app->version();
// });

$router->group([
    'prefix' => 'api'
], function() use ($router) {

    //Route for foods
    $router->group([
        'prefix' => 'foods'
    ], function() use ($router) {
        $router->get('/', 'FoodsController@index');
        $router->post('/', 'FoodsController@store');
        $router->get('/{id}', 'FoodsController@show');
        $router->delete('/{id}', 'FoodsController@destroy');
        $router->put('/{id}', 'FoodsController@update');
    });

    //Route for authentications
    $router->group([
        'prefix' => 'auth'
    ], function() use ($router) {
        $router->post('/register', 'AuthController@register');
        $router->post('/login', 'AuthController@login');
    });

    //Route for profile
    $router->group([
        'prefix' => 'profile'
    ], function() use ($router) {
        $router->get('/{id}', 'UserController@getProfile');
    });

    //Route for city
    $router->group([
        'prefix' => 'city'
    ], function() use ($router) {
        $router->post('/', 'CityController@store');
        $router->get('/', 'CityController@index');
        $router->delete('/{id}', 'CityController@delete');
    });
});