<?php

namespace App\Console\Commands;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Console\Command;

class NewsQQ extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:qq';

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
        $url = 'https://i.news.qq.com/trpc.qqnews_web.kv_srv.kv_srv_http_proxy/list';

        $offset = 0;
        $count = 199;

        $subSrvIds = [
            '24hours', "antip", "bj", "ent", "legal", "edu", "sports", "kepu", "nstock",
            "house", "comic", "history", "pet", "baby", "football", "visit", "digi", "emotion", "auto", "finance",
            "fashion", "world", "milite", "tech"
        ];

        foreach ($subSrvIds as $subSrvId) {
            echo $subSrvId.PHP_EOL;

            $params = [
                'sub_srv_id' => $subSrvId,
                'srv_id' => 'pc',
                'offset' => $offset,
                'limit' => $count,
                'strategy' => '1',
                'ext' => '{"pool":["high","top","hot"]}',
//                "ext" => '{"pool":["high","top"],"is_filter":7,"check_type":true}',
            ];

            $response = $this->guzzleClient->request('GET', $url.'?'.http_build_query($params));

            $json = $response->getBody()->getContents();

            if (!is_object($json)) {
                $this->log($url, $params, $json, '返回结果不是 JSON');
            }

            $array = json_decode($json, true);

            if ($array['ret'] !== 0) {
                $this->log($url, $params, $array, '返回结果的状态码不是 0');
            }

            $list = (array) $array['data']['list'];

            $news = [];
            foreach ($list as $item) {
                $news[] = [
                    'title' => $item['title'],
                ];
            }
            \DB::table('news')->insertOrIgnore($news);
            usleep(200 * 1000);
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
