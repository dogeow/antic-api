<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Site;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;

class BaiduSeo extends Command
{
    public GuzzleClient $guzzleClient;

    public $crawler;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spider:seo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '百度收录量';

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
            'headers' => [
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3',
                'Accept-Encoding' => 'gzip, deflate, br',
                'Accept-Language' => 'zh-CN,zh;q=0.9,en;q=0.8',
                'Cache-Control' => 'no-cache',
                'Connection' => 'keep-alive',
                'Host' => 'www.baidu.com',
                'Pragma' => 'no-cache',
                'Referer' => 'https://www.baidu.com',
                'Sec-Fetch-Mode' => 'navigate',
                'Sec-Fetch-Site' => 'same-origin',
                'Sec-Fetch-User' => '?1',
                'Upgrade-Insecure-Requests' => '1',
                'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36',
                'Cookie' => config('services.baidu.cookie'),
            ],
        ]);
    }

    public function handle(): void
    {
        $sites = Site::all();
        foreach ($sites as $site) {
            $count = $this->spider($site->domain);
            if ($count === null) {
                continue;
            }
            $site->seo = $count;
            $site->save();
        }
    }

    public function spider($domain)
    {
        $count = null;

        $url = 'http://www.baidu.com/s?wd=site:'.$domain;
        echo $url.PHP_EOL;

        try {
            $response = $this->guzzleClient->request('GET', $url);
            $content = $response->getBody()->getContents();
            if (preg_match('/找到相关结果数约(?P<count>[\d,]+)个/u', $content, $match)) {
                $count = str_replace(',', '', $match['count']);
            } elseif (preg_match('/很抱歉，没有找到与/u', $content, $matches)) {
                $count = 0;
            } else {
                $crawler = new Crawler($content);
                try {
                    $count = str_replace(',', '', $crawler->filterXPath('//span/b')->text());
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                }
            }
        } catch (\Exception  $e) {
            Log::error($e->getMessage());
        }

        echo $count.PHP_EOL;

        return $count;
    }
}
