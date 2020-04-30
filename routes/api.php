<?php

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
$api->version('v1', ['namespace' => 'App\Http\Controllers', 'middleware' => 'api'], function ($api) {
    $api->get('/', 'IndexController@url');

    $api->get('/like', 'LikeController@index');

    $api->get('/quotes', 'QuoteController');

    $api->get('/about_me', 'AboutMeController');

    $api->post('/api', 'ApiController@index');

    // 网站
    $api->get('/todo', 'ProjectController@admin');

    // Site
    $api->get('/site', 'SiteController@index');
    $api->get('/site_check', 'SiteController@check');

    // 微博热搜榜
    $api->get('/weibo/about', 'WeiboController@about');
    $api->post('/weibo', 'WeiboController@index');

    $api->get('powered-by', 'PoweredByController@index');

    // Emoji
    $api->get('/emoji', 'EmojiController@index');
    $api->post('/emoji', 'EmojiController@store');

    // Search
    $api->get('/search', 'SearchController@search');

    // API
    $api->get('parking', 'ApiController@parking');
    $api->get('number/{start}/{end}/{action?}', 'ApiController@number');
    $api->get('/html_sc/{string}', 'ApiController@htmlSC');
    $api->get('/secret/{string}', 'ApiController@secret');
    $api->get('/array', 'ApiController@array');
    $api->get('/random', 'ApiController@random');
    $api->get('/url_decode/{string}', 'ApiController@urlDecode');
    $api->get('/url_encode/{string}', 'ApiController@urlEncode');
    $api->get('/base64_encode/{string}', 'ApiController@base64_encode');
    $api->get('/base64_decode/{string}', 'ApiController@base64_decode');
    $api->get('/utf8_to_unicode/{string}', 'ApiController@utf8_to_unicode');
    $api->get('/unicode_to_utf8/{string}', 'ApiController@unicode_to_utf8');
    $api->get('/punycode/{string}', 'ApiController@punycode');
    $api->get('/image/{action}', 'ApiController@image');
    $api->get('/md5/{string}', 'ApiController@md5');
    $api->get('/user-agent', 'ApiController@userAgent');
    $api->get('/hash/{string}', 'ApiController@hash');
    $api->get('/ip/{ip?}', 'ApiController@ip')->where(['ip' => '[0-9.]+']);
    $api->get('/date/{date?}', 'ApiController@date');
    $api->get('/timestamp/{timestamp?}', 'ApiController@timestamp')->where(['timestamp' => '[0-9]+']);
    $api->get('/bankcard/{cardNo}', 'ApiController@bankcard')->where(['cardNo' => '[0-9]+']);

    $api->get('/posts', 'PostController@index');
    $api->get('/posts/{post}', 'PostController@show');

    $api->group(['middleware' => 'api.auth'], function ($api) {
        $api->resource('/posts', 'PostController', ['except' => ['index', 'show']]);
        $api->resource('/projects', 'ProjectController');
        $api->post('/tasks', 'TaskController@store');
        $api->put('/tasks/{task}', 'TaskController@update');
        // Game
        $api->get('/game', 'GameController@index');
        $api->get('/backpack', 'BackpackController@index');
    });

    $api->group(['prefix' => 'user'], function ($api) {
        $api->post('register', 'AuthController@register');
        $api->post('login', 'AuthController@login');
        $api->post('refresh', 'AuthController@refresh');

        $api->group(['middleware' => 'api.auth'], function ($api) {
            $api->put('password', 'UserController@password');
            $api->post('logout', 'AuthController@logout');
            $api->post('profile', 'AuthController@profile');
        });
    });
});
