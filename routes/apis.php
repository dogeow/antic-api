<?php
// 便民 API
use App\Http\Controllers\ApiController;
use App\Http\Controllers\JiebaController;
use Illuminate\Support\Facades\Route;

Route::post('api', [ApiController::class, 'index']);
Route::get('html_sc/{string}', [ApiController::class, 'htmlSC']);
Route::get('secret/{string?}', [ApiController::class, 'secret']);
// 图片
Route::get('images', [ApiController::class, 'images']);
// url
Route::get('url_decode/{string?}', [ApiController::class, 'urlDecode']);
Route::get('url_encode/{string?}', [ApiController::class, 'urlEncode']);
Route::get('base64_encode/{string?}', [ApiController::class, 'base64_encode']);
Route::get('base64_decode/{string?}', [ApiController::class, 'base64_decode']);
Route::get('utf8_to_unicode/{string}', [ApiController::class, 'utf8_to_unicode']);
Route::get('unicode_to_utf8/{string}', [ApiController::class, 'unicode_to_utf8']);
Route::get('punycode/{string?}', [ApiController::class, 'punycode']);
Route::get('image/{action}', [ApiController::class, 'image']);
Route::get('md5/{string?}', [ApiController::class, 'md5']);
Route::get('user-agent', [ApiController::class, 'userAgent']);
Route::get('hash/{string?}', [ApiController::class, 'hash']);
Route::get('ip/{ip?}', [
    ApiController::class, 'ip',
])->where(['ip' => '^((2(5[0-5]|[0-4]\d))|[0-1]?\d{1,2})(\.((2(5[0-5]|[0-4]\d))|[0-1]?\d{1,2})){3}$']);
// 时间
Route::get('date/{timestamp?}', [ApiController::class, 'date'])->where(['timestamp' => '[0-9]{1,10}']);
Route::get('datetime/{timestamp?}', [ApiController::class, 'datetime'])->where(['timestamp' => '[0-9]{1,10}']);
Route::get('timestamp/{date?}', [ApiController::class, 'timestamp'])->where(['date' => '[0-9-\ :]+']);
Route::get('bankcard/{cardNo}', [ApiController::class, 'bankcard'])->where(['cardNo' => '[0-9]+']);
Route::get('case/{string}', [ApiController::class, 'case']);
Route::post('url-title', [ApiController::class, 'getTitle']);
Route::get('keywords/{content}', [JiebaController::class, 'keywords']);
