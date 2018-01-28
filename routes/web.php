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


$router->post('/api/user', 'UserController@store');
$router->get('/api/user/{id}', 'UserController@view');
$router->delete('/api/user/{id}', 'UserController@delete');
$router->get('/api/users', 'UserController@list');
$router->put('/api/user/{id}', 'UserController@update');
