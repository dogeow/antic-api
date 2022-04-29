<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

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


Route::group([
    'prefix' => 'user',
], static function (): void {
    // 注册
    Route::post('register-by-email', [AuthController::class, 'registerByEmail']);
    Route::post('register-by-phone', [AuthController::class, 'registerByPhone']);
    Route::post('register', [AuthController::class, 'register']);

    // 登录
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('guest', [AuthController::class, 'guest']);
});

Route::get('pics', [ImageController::class, 'index']);
Route::get('xlsx', [ApiController::class, 'xlsx']);

Route::get('posts/tags/count', [PostController::class, 'tagsCount']);
Route::match(['get', 'post'], 'callback', [ApiController::class, 'callback']);

// 注册 认证
Route::get('oauth/github', [AuthController::class, 'redirectToProvider']);
Route::get('oauth/github/callback', [AuthController::class, 'handleProviderCallback']);
Route::post('recaptcha', [AuthController::class, 'recaptcha']);
Route::post('phoneNumberVerify', [AuthController::class, 'phoneNumberVerify']);
Route::post('emailVerify', [AuthController::class, 'emailVerify']);

// 重置 自动登录
Route::post('forget', [AuthController::class, 'forget']);
Route::post('reset', [AuthController::class, 'reset']);
Route::post('autoLogin', [AuthController::class, 'autoLogin']);

// 文章
Route::get('posts/categories/count', [PostController::class, 'categoriesCount']);

Route::group(['middleware' => 'auth:sanctum'], function (): void {
    Route::group([
        'prefix' => 'user',
    ], static function (): void {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('profile', [AuthController::class, 'profile']);
        Route::put('password', [UserController::class, 'password']);
    });

    Route::post('projects/{project}/task', [TaskController::class, 'store']);
    Route::resource('posts', PostController::class)->except(['index', 'show', 'search']);
    Route::resource('projects', ProjectController::class);
    Route::put('projects/{project}/tasks/{task}', [TaskController::class, 'update']);
    Route::post('posts/{post}/tag', [PostTagController::class, 'store']);
    Route::delete('posts/{post}/tag', [PostTagController::class, 'delete']);
});

Route::post('chat', [ChatController::class, 'message']);
Route::post('game', [GameController::class, 'loc']);
Route::get('game', [GameController::class, 'index']);

// 博饼
Route::get('moon', [MoonController::class, 'index']);
Route::post('moon', [MoonController::class, 'create']);
Route::post('start', [MoonHistoryController::class, 'start']);

// 喜欢
Route::get('like', [MyStuffController::class, 'likes']);

// 自言自语
Route::get('quotes', [MyStuffController::class, 'quotes']);
Route::get('quote', [MyStuffController::class, 'quote']);

// 关于我
Route::get('about-me', [MyStuffController::class, 'aboutMe']);

// 待办事项
Route::get('todo', [ProjectController::class, 'admin']);

// Site
Route::get('site', [SiteController::class, 'index']);
Route::get('site_check', [SiteController::class, 'check']);

// 微博热搜榜
Route::get('weibo/about', [WeiboController::class, 'about']);
Route::get('weibo', [WeiboController::class, 'index']);

// Emoji
Route::post('images', [ImageController::class, 'store']);

// Search
Route::get('search', [SearchController::class, 'search']);

// 便民 API
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
Route::post('bookmarks', [BookmarkController::class, 'create']);
Route::get('keywords/{content}', [JiebaController::class, 'keywords']);

Route::group([
    'prefix' => 'example',
], static function (): void {
    Route::get('/', [ExampleController::class, 'index']);
    Route::get('array', [ExampleController::class, 'array']);
    Route::get('number/{start}/{end}', [ApiController::class, 'number']);
});

// 文章
Route::get('posts', [PostController::class, 'index']);
Route::get('posts/{post}', [PostController::class, 'show']);
Route::get('posts/search', [PostController::class, 'search']);
Route::get('categories', [PostCategoryController::class, 'index']);
Route::get('tags', [PostTagController::class, 'index']);

// PHP 函数
Route::post('php-function', [PhpFunctionController::class, 'index']);

// 自个用
Route::get('parking', [ApiController::class, 'parking']);

Route::post('mediawiki-to-markdown', [ApiController::class, 'mediawikiToMarkdown']);
