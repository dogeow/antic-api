<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
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

Broadcast::routes(['middleware' => ['auth:sanctum']]);

Route::group([
    'prefix' => 'user',
], static function (): void {
    // 注册
    Route::post('register-by-email', [AuthController::class, 'registerByEmail']);
    Route::post('register-by-phone', [AuthController::class, 'registerByPhone']);

    // 登录
    Route::post('login', [AuthController::class, 'login']);
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
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
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

// 书签
Route::get('bookmarks', [BookmarkController::class, 'index']);
Route::post('bookmarks', [BookmarkController::class, 'create']);

Route::group([
    'prefix' => 'example',
], static function (): void {
    Route::get('/', [ExampleController::class, 'index']);
    Route::get('array', [ExampleController::class, 'array']);
    Route::get('number/{start}/{end}', [ApiController::class, 'number']);
});

// 文章
Route::get('posts', [PostController::class, 'index']);
Route::get('posts/search', [PostController::class, 'search']);
Route::get('posts/{post}', [PostController::class, 'show']);
Route::get('categories', [PostCategoryController::class, 'index']);
Route::get('tags', [PostTagController::class, 'index']);

// PHP 函数
Route::get('php-function', [PhpFunctionController::class, 'index']);

// 自个用
Route::get('parking', [ApiController::class, 'parking']);

Route::post('mediawiki-to-markdown', [ApiController::class, 'mediawikiToMarkdown']);

// 测试
Route::get('ab', [ApiController::class, 'ab']);

Route::resource('/things', ThingController::class);
Route::post('/images', [ImageController::class, 'store']);
Route::get('/tags', [TagController::class, 'index']);
Route::get('/photos', [PhotoController::class, 'index']);

require __DIR__.'/apis.php';
