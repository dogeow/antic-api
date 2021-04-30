<?php

namespace App\Console\Commands;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Console\Command;

class NewsNet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:net';

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
            "https://temp.163.com/special/00804KVA/cm_yaowen20200213_04.js?callback=data_callback&date=20200115", // 要闻
            "https://temp.163.com/special/00804KVA/cm_yaowen20200213.js?callback=data_callback&date=20200115", // 同上
            "https://temp.163.com/special/00804KVA/cm_guoji.js?callback=data_callback", // 国际
            "https://temp.163.com/special/00804KVA/cm_guonei.js?callback=data_callback", // 国内
            "https://temp.163.com/special/00804KVA/cm_war.js?callback=data_callback", // 军事
            "https://temp.163.com/special/00804KVA/cm_hangkong.js?callback=data_callback&a=2", // 航空
            "https://tech.163.com/special/00097UHL/tech_datalist.js?callback=data_callback", // 科技
            "https://temp.163.com/special/00804KVA/cm_auto.js?callback=data_callback&date=20200115", // 汽车
            "https://temp.163.com/special/00804KVA/cm_dujia.js?callback=data_callback&date=20200115", // 独家
        ];

        foreach ($urls as $url) {
            $content = file_get_contents($url);

            if (preg_match_all('/"title":"(.*?)"/', $content, $matches) === false) {
                exit("没有数据");
            }
            $news = [];
            foreach ($matches[1] as $item) {
                $news[] = [
                    "title" => mb_convert_encoding($item, "UTF-8", "GBK"),
                ];
            }
            \DB::table("news")->insertOrIgnore($news);
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
