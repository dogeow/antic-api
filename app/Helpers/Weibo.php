<?php

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
