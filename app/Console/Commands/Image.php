<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Exception;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;

class Image extends Command
{
    public $guzzleClient;

    public $crawler;

    public $site;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'image';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '获取图片';

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

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $urlPrefix = 'https://car.autohome.com.cn/jingxuan/list-0-p';
        $urlSuffix = '.html';

        $range = range(1, 157);
        $i = 0;
        foreach ($range as $page) {
            $url = $urlPrefix.$page.$urlSuffix;
            $pics = $this->getDate($url);
            foreach ($pics as $pic) {
                try {
                    $file = file_get_contents($pic);
                    file_put_contents('car/car_'.$i.'.jpg', $file);
                } catch (Exception $e) {
                } finally {
                    $i++;
                }
            }
        }
    }

    public function getDate($url): bool|array
    {
        try {
            $response = $this->guzzleClient->request('GET', $url);
        } catch (Exception $e) {
            return false;
        }

        $crawler = new Crawler($response->getBody()->getContents());

        return $crawler->filterXPath("//ul[@class='content']//img/@src")->each(function (Crawler $node) {
            return $node->text();
        });
    }
}
