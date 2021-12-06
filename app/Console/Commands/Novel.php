<?php

declare(strict_types=1);

namespace App\Console\Commands;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;

class Novel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'novel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '爬取小说';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $url = 'http://www.dingdianxs.com/5/5155/';
        $client = new GuzzleClient();
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $crawler = new Crawler($content);
        $lists = $crawler->filterXPath("//div[@id='list']/dl/dd")->each(function (Crawler $node) {
            if ($node->filterXPath('//dd/a')->count() === 0) {
                return false;
            }

            $name = $node->filterXPath('//dd/a')->text();
            $url = $node->filterXPath('//dd/a/@href')->text();

            return compact('name', 'url');
        });

        $lists = array_filter($lists);

        foreach ($lists as $list) {
            $pageUrl = $url.$list['url'];
            $response = $client->request('GET', $pageUrl);
            $content = $response->getBody()->getContents();
            $crawler = new Crawler($content);
            $txt = br2nl($crawler->filterXPath("//div[@id='content']")->html());
            file_put_contents('novel/'.$list['name'].'.txt', $txt);
        }
    }
}
