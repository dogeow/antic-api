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

    'wallpapers' => [
        'H3c772fc347444001939a064acd623d594.png',
        '329544.jpg',
        '671281.jpg',
        'ford_mustang_lithium_19_01.jpg',
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
        '4k/wallhaven-0j286p.jpg',
        '4k/wallhaven-0p2pke.jpg',
        '4k/wallhaven-0q7d7d.jpg',
        '4k/wallhaven-0qogr7.jpg',
        '4k/wallhaven-0qx6rl.jpg',
        '4k/wallhaven-132g7g.jpg',
        '4k/wallhaven-13edx3.jpg',
        '4k/wallhaven-13omov.jpg',
        '4k/wallhaven-1jyy51.jpg',
        '4k/wallhaven-2e8876.jpg',
        '4k/wallhaven-2eyrxx.jpg',
        '4k/wallhaven-2kkk6y.jpg',
        '4k/wallhaven-2kyxd6.jpg',
        '4k/wallhaven-39p8z9.jpg',
        '4k/wallhaven-3k5xvd.jpg',
        '4k/wallhaven-3krjly.jpg',
        '4k/wallhaven-43g5w3.jpg',
        '4k/wallhaven-4535y5.jpg',
        '4k/wallhaven-48pq10.jpg',
        '4k/wallhaven-49j7ek.jpg',
        '4k/wallhaven-4doo6l.jpg',
        '4k/wallhaven-4gjvrd.jpg',
        '4k/wallhaven-4gq6yd.jpg',
        '4k/wallhaven-4l5j3r.jpg',
        '4k/wallhaven-4ljoml.jpg',
        '4k/wallhaven-4ljxyn.jpg',
        '4k/wallhaven-4llqlp.jpg',
        '4k/wallhaven-4vkgzl.jpg',
        '4k/wallhaven-4xpljv.jpg',
        '4k/wallhaven-4y1jdk.jpg',
        '4k/wallhaven-4yxz2k.jpg',
        '4k/wallhaven-5wmy21.jpg',
        '4k/wallhaven-5wvz69.jpg',
        '4k/wallhaven-6k1d6l.jpg',
        '4k/wallhaven-6k7lxl.jpg',
        '4k/wallhaven-6kjjz6.jpg',
        '4k/wallhaven-6kpkxl.jpg',
        '4k/wallhaven-6q275l.jpg',
        '4k/wallhaven-6q5gmq.jpg',
        '4k/wallhaven-73kp79.jpg',
        '4k/wallhaven-73v1k9.jpg',
        '4k/wallhaven-73xkee.jpg',
        '4k/wallhaven-76g5v3.jpg',
        '4k/wallhaven-76jk5e.jpg',
        '4k/wallhaven-76qwjo.jpg',
        '4k/wallhaven-76rlre.jpg',
        '4k/wallhaven-83e9ok.jpg',
        '4k/wallhaven-83ojgo.jpg',
        '4k/wallhaven-8x16oj.png',
        '4k/wallhaven-8x9zw1.jpg',
        '4k/wallhaven-95x95d.jpg',
        '4k/wallhaven-96gqz8.jpg',
        '4k/wallhaven-96kwk1.jpg',
    ],
];
