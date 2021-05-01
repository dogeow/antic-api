<?php

namespace App\Console\Commands;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;

class NewsPeople extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:people';

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
        $url = "http://news.people.com.cn/210801/211150/index.js";

        $content = file_get_contents($url);

        $array = json_decode($content, true);

        $news = [];
        foreach ($array['items'] as $item) {
            $news[] = [
                'title' => $item['title'],
            ];
        }
        \DB::table('news')->insertOrIgnore($news);
    }

    public function log($url, $params, $response, $message)
    {
        \Log::error($url);
        \Log::error(var_export($params, true));
        \Log::error(var_export($response, true));
        \Log::error($message);
    }
}
