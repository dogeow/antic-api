<?php

namespace App\Console\Commands;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Console\Command;

class News6do extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:6do';

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
        $url = 'https://6do.news/api/article/recommend?page=1';

        $userAgent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36';
        $proxy = 'http://127.0.0.1:1087';

        $json = $this->curl($url, $userAgent, $proxy);
        $array = json_decode($json, true, );

        if ($array['status_code'] !== 200) {
            exit($array['error']);
        }

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

    public function curl($url, $user_agent, $proxy)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_PROXY, $proxy);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}
