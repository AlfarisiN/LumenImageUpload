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
    $router->post('upload', ['uses' => 'FileController@store']);
    $router->post('datausers', ['uses' => 'TestController@ambildata']);
    $router->post('update', ['uses' => 'TestController@upload']);
    $router->post('update2', ['uses' => 'TestController@upload2']);
    $router->post('update3', ['uses' => 'TestController@upload3']);
    $router->get('user/avatar/{name}', 'TestController@get_avatar');
});
