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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'tests'], function () use ($router) {
    $router->get('data', ['uses' => 'TestController@ambildata']);
    $router->post('update', ['uses' => 'TestController@upload']);
    $router->get('/user/avatar/', 'TestController@get_avatar');
    $router->get('read', ['uses' => 'TestController@readData']);
});
