<?php

declare(strict_types=1);

use App\Models\Quote;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Overtrue\EasySms\EasySms;

Artisan::command('inspire', function (): void {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('test', function (): void {
    $config = [
        'timeout' => 5.0,
        'default' => [
            'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,
            'gateways' => ['aliyun'],
        ],
        'gateways' => [
            'errorlog' => [
                'file' => '/tmp/easy-sms.log',
            ],
            'aliyun' => [
                'access_key_id' => '',
                'access_key_secret' => '',
                'sign_name' => '',
            ],
        ],
    ];
    $easySms = new EasySms($config);

    $easySms->send(18650036080, [
        'content' => '您的验证码为: 6379',
        'template' => 'SMS_001',
        'data' => [
            'code' => 6379,
        ],
    ]);
//    DB::enableQueryLog(); // Enable query log
//    dd(DB::getQueryLog()); // Show results of log

//    print_r($result);
//    Log::channel('file_download')->info('信息', ['xx' => 'xx']);
//    Log::channel('file_download')->debug('信息', ['xx' => 'xx']);
//    Post::all()->searchable();
//    broadcast(new App\Events\TestBroadcastingEvent('233'));
//    Notification::send(new User, new BuildNotification('233'));
});

Artisan::command('test2', function (): void {
    if (preg_match('/(.)\1{4,}/', '2333', $matches)) {
        echo '233';
    }

    DB::enableQueryLog(); // Enable query log

    $a = \App\Models\Post::whereHas(
        'tags',
        function ($query): void {
            $query->where('name', '233');
        }
    )->get()->toArray();
    dd(DB::getQueryLog()); // Show results of log
});

Artisan::command('test3', function (): void {
    DB::enableQueryLog();
    $a = Quote::first();
    $a->timestamps = true;
    $a->update(['content' => '真的3323232332吗']);

    dd(DB::getQueryLog());
});
