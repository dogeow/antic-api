<?php

namespace App\Http\Controllers;

use AsciiTable\Builder;

class HomeController
{
    public function __invoke()
    {
        $builder = new Builder();

        $appUrl = config('app.url');
        $prefix = "curl $appUrl/";

        $apis = [
            [
                'name' => 'ip',
                'both' => 1,
                'param_name' => 'ip',
                'param' => '127.0.0.1',
                'intro' => '获取 ip 地址',
                'param_intro' => '根据 ip 地址获取地理位置',
            ],
            [
                'name' => 'date',
                'both' => 1,
                'param_name' => '时间戳',
                'param' => '1650270873',
                'intro' => '获取当天日期',
                'param_intro' => '根据时间戳转日期',
            ],
            [
                'name' => 'datetime',
                'both' => 1,
                'param_name' => '时间戳',
                'param' => '1650270873',
                'intro' => '获取现在的日期时间',
                'param_intro' => '根据时间戳转日期时间',
            ],
            [
                'name' => 'timestamp',
                'both' => 1,
                'param_name' => '日期或时间',
                'param' => '2022-03-12 08:15:00',
                'intro' => '现在的时间戳',
                'param_intro' => '根据日期或时间转时间戳',
            ],
            [
                'name' => 'case',
                'both' => 0,
                'param_name' => '英语单词',
                'param' => 'categories',
                'intro' => '',
                'param_intro' => '英语单词自动切换大小写',
            ],
        ];

        $newApis = [];
        foreach ($apis as $api) {
            if ($api['both'] === 1) {
                $newApis[] = [
                    '端点' => $api['name'],
                    '参数' => '',
                    '参数示例值' => '',
                    '说明' => $api['intro'],
                    '完整示例' => $prefix.$api['name'],
                ];
            }
            $newApis[] = [
                '端点' => $api['name'],
                '参数' => $api['param_name'],
                '参数示例值' => $api['param'],
                '说明' => $api['param_intro'],
                '完整示例' => $prefix.$api['name'].'/'.str_replace(' ', '%20', $api['param']),
            ];
        }

        $builder->addRows($newApis);

        return $builder->renderTable();
    }
}
