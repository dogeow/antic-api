<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FilterKeyword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'filter:keyword';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {

        $arr = [
            "雪山",
            "大峡谷",
            "长城",
        ];

        $arr = array_unique($arr);

        // 判断字符，大于三个中文的不要，小于两个字的也不要
        foreach ($arr as $key => $value) {
            $len = mb_strlen($value);
            if ($len > 3) {
                $value = preg_replace('/(.*?)(水库|湖泊|保护区)$/', '$1', $value);
            }

            $len = mb_strlen($value);
            if (in_array($len, [2, 3])) {
                echo $value.PHP_EOL;
            }
        }
    }
}
