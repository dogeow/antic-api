<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class giveNameOld extends Command
{
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

    /**
     * @var Client
     */
    private Client $client;

    private int $concurrency = 50;  // 同时并发抓取

    private float $totalPageCount = 1e1000;

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
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $sex = $this->argument('sex');

        $requests = static function ($total) use ($sex) {
            $uri = 'https://www.quming.com/quming/';
            for ($i = 0; $i < $total; $i++) {
                yield new Request('POST', $uri, [
                    'form_params' => [
                        'gsname' => '',
                        'sex' => $sex,
                        'action' => 'test',
                    ],
                ]);
            }
        };

        $pool = new Pool($this->client, $requests($this->totalPageCount), [
            'concurrency' => $this->concurrency,
            'fulfilled' => function ($response, $index) {
                $this->info("请求第 $index 个请求");
                $content = $response->getBody()->getContents();

                if (preg_match_all('/rel="nofollow">(.*?)</', $content, $matches)) {
                    $query = '';
                    foreach ($matches[1] as $name) {
                        $query .= "INSERT IGNORE INTO test (name, sex) VALUES ('$name', {$this->argument('sex')});";
                    }
                    DB::unprepared($query);
                }
            },
            'rejected' => static function ($reason, $index) {
            },
        ]);

        $promise = $pool->promise();
        $promise->wait();
    }
}
