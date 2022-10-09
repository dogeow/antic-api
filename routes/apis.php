<?php

// 便民 API
use App\Http\Controllers\ApiController;
use App\Http\Controllers\JiebaController;
use Illuminate\Support\Facades\Route;

Route::controller(ApiController::class)->group(function () {
    Route::get('case/{string}', 'case');
    Route::post('api', 'index');
    Route::get('html_sc/{string}', 'htmlSC');
    Route::get('secret/{string?}', 'secret');

    // 图片
    Route::get('images', 'images');

    // url
    Route::get('url_decode/{string?}', 'urlDecode');
    Route::get('url_encode/{string?}', 'urlEncode');
    Route::get('base64_encode/{string?}', 'base64_encode');
    Route::get('base64_decode/{string?}', 'base64_decode');
    Route::get('utf8_to_unicode/{string}', 'utf8_to_unicode');
    Route::get('unicode_to_utf8/{string}', 'unicode_to_utf8');
    Route::get('punycode/{string?}', 'punycode');
    Route::get('image/{action}', 'image');
    Route::get('md5/{string?}', 'md5');
    Route::get('user-agent', 'userAgent');
    Route::get('hash/{string?}', 'hash');
    Route::get('ip/{ip?}', [
        ApiController::class, 'ip',
    ])->where(['ip' => '^((2(5[0-5]|[0-4]\d))|[0-1]?\d{1,2})(\.((2(5[0-5]|[0-4]\d))|[0-1]?\d{1,2})){3}$']);

    // 时间
    Route::get('date/{timestamp?}', 'date')->where(['timestamp' => '[0-9]{1,10}']);
    Route::get('datetime/{timestamp?}', 'datetimeToTimestamp')->where(['timestamp' => '[0-9]{1,10}']);
    Route::get('timestamp/{date?}', 'timestamp')->where(['date' => '[0-9-\ :]+']);
    Route::get('bankcard/{cardNo}', 'bankcard')->where(['cardNo' => '[0-9]+']);

    Route::get('url-title', 'getTitle');
});

Route::get('keywords/{content}', [JiebaController::class, 'keywords']);
