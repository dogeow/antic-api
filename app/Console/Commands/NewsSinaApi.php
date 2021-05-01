<?php

namespace App\Console\Commands;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Console\Command;

class NewsSinaApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:sina-api';

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
        $url = "https://cre.mix.sina.com.cn/api/v3/get";

        $content = file_get_contents($url);

        $array = json_decode($content, true);

        $news = [];
        foreach ($array['data'] as $item) {
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
