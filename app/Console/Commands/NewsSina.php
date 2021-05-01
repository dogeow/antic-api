<?php

namespace App\Console\Commands;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Console\Command;

class NewsSina extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:sina';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '爬新闻标题';

    public GuzzleClient $guzzleClient;
    public $crawler;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->guzzleClient = new GuzzleClient([
            'timeout' => 10,
        ]);
    }

    public function handle()
    {
        $urls = [
            'http://feed.mix.sina.com.cn/api/roll/get?pageid=153&lid=2509&k=&num=50&page=1',
            'http://feed.mix.sina.com.cn/api/roll/get?pageid=382&lid=2990&k=&num=50&page=1',
            'http://feed.sina.com.cn/api/roll/get?pageid=51&lid=740&num=50&page=1',
        ];

        foreach ($urls as $url) {
            $content = file_get_contents($url);

            $array = json_decode($content, true);

            if (empty($array['result']['data'])) {
                exit('没有数据');
            }

            $data = $array['result']['data'];

            $news = [];
            foreach ($data as $item) {
                $news[] = [
                    'title' => $item['title'],
                ];
            }
            \DB::table('news')->insertOrIgnore($news);
        }
    }

    public function log($url, $params, $response, $message)
    {
        \Log::error($url);
        \Log::error(var_export($params, true));
        \Log::error(var_export($response, true));
        \Log::error($message);
    }
}