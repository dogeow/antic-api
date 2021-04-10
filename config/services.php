<?php

return [
    'access_key_id' => env('ACCESS_KEY_ID'),
    'access_key_secret' => env('ACCESS_KEY_SECRET'),
    'recaptcha' => env('RECAPTCHA'),
    'github' => [
        'client_id' => env('GITHUB_CLIENT_ID'),
        'client_secret' => env('GITHUB_CLIENT_SECRET'),
        'redirect' => '',
        'web_hook_secret' => env('WEB_HOOK_SECRET'),
        'web_hook_path' => env('WEB_HOOK_PATH'),
    ],
    'slack' => [
        'webhook_url' => env('SLACK_WEBHOOK_URL'),
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
    'baidu' => ['cookie' => env('BAIDU_COOKIE')],
    'sql_debug_log' => env('SQL_DEBUG_LOG'),
];
