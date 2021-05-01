<?php

namespace App\Console\Commands;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;

class NewsChina extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:china';

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
        $url = 'http://www.chinanews.com/scroll-news/news1.html';

        $content = file_get_contents($url);

        $crawler = new Crawler($content);

        $all = $crawler->filterXPath("//div[@class='dd_bt']/a")->each(function (Crawler $node) {
            return $node->text();
        });

        $news = [];
        foreach ($all as $item) {
            $news[] = [
                'title' => $item,
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
