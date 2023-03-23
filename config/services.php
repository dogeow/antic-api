<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    // UPYUN
    'upyun_endpoint' => env('UPYUN_ENDPOINT'),

    // OSS
    'access_key_id' => env('ACCESS_KEY_ID'),
    'access_key_secret' => env('ACCESS_KEY_SECRET'),
    'oss_endpoint' => env('OSS_ENDPOINT'),

    // Google Recaptcha
    'recaptcha' => env('RECAPTCHA'),

    // GitHub 第三方登录
    'github' => [
        'client_id' => env('GITHUB_CLIENT_ID'),
        'client_secret' => env('GITHUB_CLIENT_SECRET'),
        'redirect' => '',
    ],

    // 测试账号
    'test_user' => [
        'name' => '测试用户',
        'email' => 'guest@dogeow.com',
        'password' => 'A123456.',
    ],

    'slack' => [
        'webhook_url' => env('SLACK_WEBHOOK_URL'),
    ],

    'sql_debug_log' => env('SQL_DEBUG_LOG'),

    'openai' => [
        'api_key' => env('OPENAI_API_KEY'),
    ],
    'upyun' => [
        'bucket_name' => env('UPYUN_BUCKET_NAME'),
        'operator_name' => env('UPYUN_OPERATOR_NAME'),
        'operator_password' => env('UPYUN_OPERATOR_PASSWORD'),
    ],
];
