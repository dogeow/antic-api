<?php

declare(strict_types=1);

if (! function_exists('status')) {
    function status($status): ?string
    {
        return match ($status) {
            '新' => ' new',
            '热' => ' hot',
            '沸' => ' boil',
            default => null,
        };
    }
}

/*
 * 格式化字节大小
 *
 * @param  int  $size  字节数
 * @param  int  $base  MiB 或 MB，即 1024 或 1000
 * @param  string  $delimiter  数字和单位分隔符
 * @return string 格式化后的带单位的大小
 */

if (! function_exists('bytesForHuman')) {
    function bytesForHuman(int $size, int $base = 1024, string $delimiter = ''): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
        for ($i = 0; $size >= $base && $i < 5; $i++) {
            $size /= $base;
        }

        return round($size, 2).$delimiter.$units[$i];
    }
}

/*
 * 微博热度
 *
 * @param  int  $size  热度
 * @return string 格式化后的带单位的大小
 */
if (! function_exists('weiboHotForHuman')) {
    function weiboHotForHuman(int $size): string
    {
        $units = ['', 'K', 'M', 'G'];
        for ($i = 0; $size >= 1000 && $i < 5; $i++) {
            $size /= 1000;
        }

        return round($size).$units[$i];
    }
}

if (! function_exists('topping')) {
    function topping($topping)
    {
        if ((is_countable($topping) ? count($topping) : 0) >= 2) {
            $diff = $topping[0]->created_at->diffInMinutes($topping[1]->created_at);
            if ($diff > 2) {
                $topping->pop();
            }
        }

        return $topping;
    }
}
