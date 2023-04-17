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
