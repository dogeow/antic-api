<?php

// 便民 API
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::controller(ApiController::class)->group(function () {
    Route::get('api', 'index');

    Route::get('keywords/{content}', 'keywords');

    // 图片
    Route::get('images', 'images');

    // 编码
    Route::get('url_decode/{string?}', 'urlDecode');
    Route::get('url_encode/{string?}', 'urlEncode');
    Route::get('base64_encode/{string?}', 'base64_encode');
    Route::get('base64_decode/{string?}', 'base64_decode');
    Route::get('utf8_to_unicode/{string}', 'utf8_to_unicode');
    Route::get('unicode_to_utf8/{string}', 'unicode_to_utf8');
    Route::get('idn-to-ascii/{string}', 'idnToAscii');
    Route::get('idn-to-ascii/{string}', 'idnToUtf8');
    Route::get('md5/{string?}', 'md5');
    Route::get('hash/{string?}', 'hash');

    Route::get('case/{string}', 'case');
    Route::get('html_sc/{string}', 'htmlSC');
    Route::get('secret/{string?}', 'secret');
    Route::get('image/{action}', 'image');
    Route::get('user-agent', 'userAgent');
    Route::get('ip/{ip?}', [ApiController::class, 'ip'])
        ->where(['ip' => '^((2(5[0-5]|[0-4]\d))|[0-1]?\d{1,2})(\.((2(5[0-5]|[0-4]\d))|[0-1]?\d{1,2})){3}$']);

    // 时间
    Route::get('date/{timestamp?}', 'date')->where(['timestamp' => '[0-9]{1,10}']);
    Route::get('datetime/{timestamp?}', 'datetimeToTimestamp')->where(['timestamp' => '[0-9]{1,10}']);
    Route::get('timestamp/{date?}', 'timestamp')->where(['date' => '[0-9-\ :]+']);

    // 需要请求数据
    Route::get('bankcard/{cardNo}', 'bankcard')->where(['cardNo' => '[0-9]+']);
    Route::get('url-title', 'getTitle');

    Route::post('ai', 'ai');

    Route::get('ip/{ip}/info', 'ipInfo');
});
