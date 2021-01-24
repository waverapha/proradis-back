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

$router->group([
    'prefix' => '/patients',
], function () use ($router) {
    $router->get('/', [
        'as' => 'patient.index',
        'uses' => 'PatientController@index'
    ]);

    $router->get('/{id}', [
        'as' => 'patient.show',
        'uses' => 'PatientController@show'
    ]);

    $router->post('/', [
        'as' => 'patient.store',
        'uses' => 'PatientController@store'
    ]);

    $router->put('/{id}', [
        'as' => 'patient.update',
        'uses' => 'PatientController@update'
    ]);

    $router->delete('/{id}', [
        'as' => 'patient.destroy',
        'uses' => 'PatientController@destroy'
    ]);
});
