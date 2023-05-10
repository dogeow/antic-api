<?php

namespace App\Console\Commands\Old;

use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class giveName extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'give-name {sex=m : Sex to use (m/f)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape Chinese names from 517ming.com';

    private readonly Client $client;

    private array $firstName;

    private int $concurrency = 50;  // 同时并发抓取

    private float $totalPageCount = 100;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->client = new Client([
            'timeout' => 10,
        ]);
        $this->firstName = [
            "王", "李", "张", "刘", "陈", "杨", "黄", "赵", "吴", "周",
            "徐", "孙", "马", "朱", "胡", "郭", "何", "高", "林", "郑",
            "谢", "罗", "梁", "宋", "唐", "许", "韩", "冯", "邓", "曹",
            "彭", "曾", "蕭", "田", "董", "袁", "潘", "于", "蒋", "蔡",
            "余", "杜", "叶", "程", "苏", "魏", "吕", "丁", "任", "沈",
            "姚", "卢", "姜", "崔", "钟", "谭", "陆", "汪", "范", "金",
            "石", "廖", "贾", "夏", "韦", "付", "方", "白", "邹", "孟",
            "熊", "秦", "邱", "江", "尹", "薛", "闫", "段", "雷", "侯",
            "龙", "史", "陶", "黎", "贺", "顾", "毛", "郝", "龚", "邵",
            "万", "钱", "严", "覃", "武", "戴", "莫", "孔", "向", "汤",
        ];
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $sex = strtolower($this->argument('sex'));
        if (! in_array($sex, ['m', 'f'])) {
            $this->error('Invalid sex specified. Use m or f.');
            return;
        }

        $uriTemplate = 'http://www.517ming.com/datafile/517v2/t1/%s2/%s/';
        $requests = function ($total) use ($sex, $uriTemplate) {
            foreach ($this->firstName as $item) {
                for ($i = 0; $i < $total; $i++) {
                    yield new Request('GET', sprintf($uriTemplate, $sex, $item));
                }
            }
        };

        $pool = new Pool($this->client, $requests($this->totalPageCount), [
            'concurrency' => $this->concurrency,
            'fulfilled' => function ($response, $index): void {
                $this->info("请求第 $index 个请求");
                $content = $response->getBody()->getContents();
                $names = collect();
                $names = $names->concat(explode(',', $content));

                $data = $names->unique()->map(function ($name) {
                    return ['name' => $name,];
                })->all();

                DB::table('test')->insertOrIgnore($data);
            },
            'rejected' => static function ($reason, $index): void {
            },
        ]);

        $promise = $pool->promise();
        $promise->wait();
    }
}
