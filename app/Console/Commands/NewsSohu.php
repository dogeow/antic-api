<?php

namespace App\Console\Commands;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Console\Command;

class NewsSohu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:sohu';

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
        $categories = [1460, 1461, 1462, 1463, 1464];

        foreach ($categories as $category) {
            $url = "https://v2.sohu.com/public-api/feed?scene=CATEGORY&sceneId={$category}&page=1&size=100";
            $content = file_get_contents($url);
            $array = json_decode($content, true,);

            $news = [];
            foreach ($array as $item) {
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
