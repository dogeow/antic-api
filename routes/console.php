<?php

use App\Models\Post;
use App\Models\User;
use App\Notifications\BuildNotification;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Notification;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('test', function () {
//    $result = OSS::put('233/robots.txt', file_get_contents(public_path('robots.txt')));
//    \
//    print_r($result);
//    Log::channel('file_download')->info('信息', ['xx' => 'xx']);
//    Log::channel('file_download')->debug('信息', ['xx' => 'xx']);
//    Post::all()->searchable();
//    broadcast(new App\Events\TestBroadcastingEvent('233'));
    Notification::send(new User, new BuildNotification('233'));
});
