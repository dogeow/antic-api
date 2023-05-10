<?php

namespace App\Console\Commands\Old;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GiveNameOld extends Command
{
    private const CONCURRENCY = 50; // 同时并发抓取

    private const TIMEOUT = 10; // 请求超时时间

    private const URI = 'https://www.quming.com/quming/';

    private const QUERY_TEMPLATE = "INSERT IGNORE INTO test (name, sex) VALUES ('%s', '%s');";

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'giveNameOld {sex}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '爬取名网';

    private Client $client;

    private int $totalPageCount = 1000;

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
        $this->client = new Client([
            'timeout' => self::TIMEOUT,
        ]);
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $sex = $this->argument('sex');

        $requests = static function ($total) use ($sex) {
            for ($i = 0; $i < $total; $i++) {
                yield new Request('POST', self::URI, [
                    'form_params' => [
                        'gsname' => '',
                        'sex' => $sex,
                        'action' => 'test',
                    ],
                ]);
            }
        };

        $pool = new Pool($this->client, $requests($this->totalPageCount), [
            'concurrency' => self::CONCURRENCY,
            'fulfilled' => function ($response, $index): void {
                $this->info("请求第 ${index} 个请求");
                $content = $response->getBody()->getContents();

                if (preg_match_all('/rel="nofollow">(.*?)</', $content, $matches)) {
                    $query = '';
                    foreach ($matches[1] as $name) {
                        $escapedName = addslashes($name);
                        $query .= sprintf(self::QUERY_TEMPLATE, $escapedName, $this->argument('sex'));
                    }
                    DB::unprepared($query);
                }
            },
            'rejected' => function ($reason, $index) {
                if ($reason instanceof RequestException) {
                    $this->error("请求第 ${index} 个请求失败：" . $reason->getMessage());
                } else {
                    $this->error("请求第 ${index} 个请求失败");
                }
            },
        ]);

        $promise = $pool->promise();
        $promise->wait();
    }
}
