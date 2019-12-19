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

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['namespace' => 'App\Http\Controllers\V1', 'middleware' => 'api'], function ($api) {
    $api->get('test', 'AuthController@test');

    $api->group(['prefix' => 'user'], function ($api) {
        $api->post('sign-up', 'AuthController@signUp');
        $api->post('sign-in', 'AuthController@signIn');
        $api->post('sign-out', 'AuthController@signOut');
        $api->post('refresh', 'AuthController@refresh');
        $api->post('profile', 'AuthController@profile');
    });
});
