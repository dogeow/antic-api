<?php

return [
    'access_key_id' => env('ACCESS_KEY_ID'),
    'access_key_secret' => env('ACCESS_KEY_SECRET'),
    'recaptcha' => env('RECAPTCHA'),
    'github' => [
        'client_id' => env('GITHUB_CLIENT_ID'),
        'client_secret' => env('GITHUB_CLIENT_SECRET'),
        'redirect' => '',
    ],
    'meituan' => [
        'error' => [
            'errcode' => '1',
            'errmsg' => 'err',
        ],
        'success' => [
            'errcode' => '0',
            'errmsg' => 'ok',
        ],
    ],
];
