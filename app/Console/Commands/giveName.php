<?php

namespace App\Console\Commands;

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
    protected $signature = 'giveName {sex}';

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

    private $firstName;

    private int $concurrency = 50;  // 同时并发抓取
    private float $totalPageCount = 1e2;

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
        $this->firstName = config('firstname');
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $requests = function ($total) {
            foreach ($this->firstName as $item) {
                for ($i = 0; $i < $total; $i++) {
                    $uri = 'http://www.517ming.com/datafile/517v2/t1/'.$this->argument('sex').'2/'.$item.'/';
                    yield new Request('GET', $uri);
                }
            }
        };

        $pool = new Pool($this->client, $requests($this->totalPageCount), [
            'concurrency' => $this->concurrency,
            'fulfilled' => function ($response, $index) {
                $this->info("请求第 $index 个请求");
                $content = $response->getBody()->getContents();

                $names = explode(',', $content);
                $categoryId = array_search(mb_substr($names[0], 0, 1), $this->firstName, true);

                $query = '';
                foreach ($names as $name) {
                    print_r($names);
                    $sexId = self::sexId();
                    $query .= "INSERT IGNORE INTO test (name, sex, category_id, count) VALUES ('$name', {$sexId}, $categoryId, 3);";
                }
                DB::unprepared($query);
            },
            'rejected' => static function ($reason, $index) {
            },
        ]);

        $promise = $pool->promise();
        $promise->wait();
    }

    public function sexId(): int
    {
        switch ($this->argument('sex')) {
            case 'f':
                return 1;
            case 'm':
                return 0;
        }
    }
}
