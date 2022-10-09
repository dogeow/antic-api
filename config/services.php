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
        'web_hook_secret' => env('WEB_HOOK_SECRET'),
        'web_hook_path' => env('WEB_HOOK_PATH'),
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

    'wallpapers' => [
        'H3c772fc347444001939a064acd623d594.png',
        '329544.jpg',
        '671281.jpg',
        'ford_mustang_lithium_19_01.jpg',
        'P90184809-bmw-3-0-csl-hommage-05-2015-2867px.jpg',
        'th.jpeg',
        'unnamed.jpg',
        '3C83FFC7927000A1A41412969F5EE9AB.png',
        '457D489F7BB124BE5E8E9EB6F5675C13.png',
        '8695FC3E81CA658C6FD3E1F8B3DE72B9.png',
        '702620.png',
        '疯狂动物城.png',
        'AIR.jpg',
        'LiveForSpeed.jpg',
        '你的名字.jpg',
        '塞尔达荒野之息.jpg',
        '守望先锋.jpg',
        '骑士.jpeg',
        'spaces/03821_bridalveiltrickes_3840x2400.jpg',
        'spaces/03875_atlantisnebula4_3840x2400.jpg',
        'spaces/03887_celestialfireworks_3840x2400.jpg',
        'spaces/03888_calbucosrage_3840x2400.jpg',
        'spaces/03898_monacoformulaesunrise2015_3840x2400.jpg',
        'spaces/03899_milkywayoverathawingbowlake_3840x2400.jpg',
        'spaces/03928_atlantisnexusnebula_3840x2400.jpg',
        'spaces/03941_rumkale_3840x2400.jpg',
        'spaces/03943_endlesslights_3840x2400.jpg',
        'spaces/52211586681_1e95f5ec38_o.png',
        'spaces/52211883534_5987bc6836_k.jpeg',
        'spaces/Endless....jpg',
        'spaces/M31NMmosaicLL.jpg',
        'spaces/Musk.jpg',
        'spaces/ablueeveninginportland.jpg',
        'spaces/ayersrockunderstars.jpg',
        'spaces/banffaurora.jpg',
        'spaces/cinqueterre.jpg',
        'spaces/clearskieswithachanceofprotonbombardment.jpg',
        'spaces/colorfulmasterpiece.jpg',
        'spaces/cosmologicalmasterpiece.jpg',
        'spaces/dawnonlaketoba.jpg',
        'spaces/earthrise.jpg',
        'spaces/enchantingporto.jpg',
        'spaces/fishingbaldeagle.jpg',
        'spaces/forbiddenroad.jpg',
        'spaces/frozenreservoir.jpg',
        'spaces/glendavis.jpg',
        'spaces/iceboxcluster.jpg',
        'spaces/img (54).jpg',
        'spaces/jetincarina.jpg',
        'spaces/lakeviewvalleydusk.jpg',
        'spaces/lonelypair.jpg',
        'spaces/manarolanight.jpg',
        'spaces/moonlitnight.jpg',
        'spaces/moonriseoveryosemite.jpg',
        'spaces/mustafariansunrise.jpg',
        'spaces/narrabeenlakesdawn.jpg',
        'spaces/neuschwanstein.jpg',
        'spaces/nightfallatlakeaurora.jpg',
        'spaces/nightskyofsicily.jpg',
        'spaces/observatoryhillsunset.jpg',
        'spaces/oneway.jpg',
        'spaces/picography-mountain-snow-sunset-stars-sky-eberhard-grossgasteiger-1.jpg',
        'spaces/sliceoffire.jpg',
        'spaces/starrynight.jpg',
        'spaces/stars-over-lake.jpg',
        'spaces/starsoverjoshuatree.jpg',
        'spaces/stormyatmosphereofmerphlyn.jpg',
        'spaces/sunsetoverportland.jpg',
        'spaces/tarantulaslairnebula.jpg',
        'spaces/theeleventhhour.jpg',
        'spaces/thegalacticcenter.jpg',
        'spaces/thehelixnebulasiridescentglory.jpg',
        'spaces/trion.jpg',
        'spaces/tropiccoldnight.jpg',
        'spaces/tucsonsupermoon.jpg',
        'spaces/tyrrhenum.jpg',
        'spaces/valleyofthestars.jpg',
        'spaces/villefranchesurmertwilightsunset.jpg',
    ]
];
