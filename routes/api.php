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

Route::group(['middleware' => 'api'], function ($api) {
    Route::get('/', 'IndexController@url');

    Route::post('/moon', 'MoonController@create');
    Route::get('/moon', 'MoonController@index');
    Route::post('/start', 'MoonHistoryController@start');

    Route::get('/index', 'IndexController@index');

    Route::get('/recaptcha', 'AuthController@recaptcha');

    Route::get('/like', 'LikeController@index');

    Route::get('/quotes', 'QuoteController@index');

    Route::get('/about_me', 'AboutMeController@index');

    Route::post('/api', 'ApiController@index');

    // 网站 todo
    Route::get('/todo', 'ProjectController@admin');

    // Site
    Route::get('/site', 'SiteController@index');
    Route::get('/site_check', 'SiteController@check');

    // 微博热搜榜
    Route::get('/weibo/about', 'WeiboController@about');
    Route::post('/weibo', 'WeiboController@index');

    Route::get('powered-by', 'PoweredByController@index');

    // Emoji
    Route::get('/emoji', 'ImageController@index');
    Route::post('/emoji', 'ImageController@store');

    // Search
    Route::get('/search', 'SearchController@search');

    // API
    Route::get('parking', 'ApiController@parking');
    Route::get('number/{start}/{end}/{action?}', 'ApiController@number');
    Route::get('/html_sc/{string}', 'ApiController@htmlSC');
    Route::get('/secret/{string}', 'ApiController@secret');
    Route::get('/array', 'ApiController@array');
    Route::get('/random', 'ApiController@random');
    Route::get('/url_decode/{string}', 'ApiController@urlDecode');
    Route::get('/url_encode/{string}', 'ApiController@urlEncode');
    Route::get('/base64_encode/{string}', 'ApiController@base64_encode');
    Route::get('/base64_decode/{string}', 'ApiController@base64_decode');
    Route::get('/utf8_to_unicode/{string}', 'ApiController@utf8_to_unicode');
    Route::get('/unicode_to_utf8/{string}', 'ApiController@unicode_to_utf8');
    Route::get('/punycode/{string}', 'ApiController@punycode');
    Route::get('/image/{action}', 'ApiController@image');
    Route::get('/md5/{string}', 'ApiController@md5');
    Route::get('/user-agent', 'ApiController@userAgent');
    Route::get('/hash/{string}', 'ApiController@hash');
    Route::get('/ip/{ip?}', 'ApiController@ip')->where(['ip' => '[0-9.]+']);
    Route::get('/date/{date?}', 'ApiController@date');
    Route::get('/timestamp/{timestamp?}', 'ApiController@timestamp')->where(['timestamp' => '[0-9]+']);
    Route::get('/bankcard/{cardNo}', 'ApiController@bankcard')->where(['cardNo' => '[0-9]+']);

    Route::get('/posts', 'PostController@index');
    Route::get('/posts/{post}', 'PostController@show');
    Route::get('/categories', 'PostCategoryController@index');
    Route::get('/tags', 'PostTagController@index');

    Route::group(['middleware' => 'auth:api'], function ($api) {
        Route::resource('/posts', 'PostController', ['except' => ['index', 'show']]);
        Route::resource('/projects', 'ProjectController');
        Route::post('/tasks', 'TaskController@store');
        Route::put('/tasks/{task}', 'TaskController@update');
        // Game
        Route::get('/game', 'GameController@index');
        Route::get('/backpack', 'BackpackController@index');
    });

    Route::group(['prefix' => 'user'], function ($api) {
        Route::post('register', 'AuthController@register');
        Route::post('login', 'AuthController@login');
        Route::post('refresh', 'AuthController@refresh');

        Route::group(['middleware' => 'auth:api'], function ($api) {
            Route::put('password', 'UserController@password');
            Route::post('logout', 'AuthController@logout');
            Route::post('profile', 'AuthController@profile');
        });
    });
});
