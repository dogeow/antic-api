<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Site;
use Exception;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;

class Juming extends Command
{
    public GuzzleClient $guzzleClient;

    public Crawler $crawler;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'juming';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '百度收录量';

    public function handle(): void
    {
//        $this->guzzleClient = new GuzzleClient([
//            'headers' => [
//                'Cookie' => 'PHPSESSID=k51lfb3m93stp1ql6vmq8fhthd; Hm_lvt_e1ebf2669a3f84111be8b83567f3f668=1677513902; Hm_lpvt_e1ebf2669a3f84111be8b83567f3f668=1677513902; _uab_collina=167751390424044980333651; Juming_uid=52980; Juming_isapp=0; Juming_zhu=db36f248172f4a5b0edcfcbb46199434; Juming_jf=81725f273e9f1e0530452413b53a06e5; Juming_qy=de7baaa5b0bc7393f8ca36ece08c4434',
//            ],
//        ]);
//
//        // 2020年4月25号到2023年3月4号的日期
//        foreach (range(1587744000, 1677859200, 86400) as $time) {
//            $date = date('Y-m-d', $time);
//            $url = 'https://www.juming.com/newcha/del_down?scsj='.$date;
//
//            try {
//                $request = $this->guzzleClient->get($url);
//                file_put_contents('domains/'.$date.'.txt', $request->getBody()->getContents());
//            } catch (\Exception $e) {
//                echo $date.PHP_EOL;
//            }
//        }

        // 内存不限制
        ini_set('memory_limit', '-1');

        // 从 domains 文件夹读取所有 txt 文件
        $files = scandir('domains');
        foreach ($files as $file) {
            if($file < '2023-01-28.txt') {
                continue;
            }

            echo $file.PHP_EOL;

            $content = file_get_contents('domains/'.$file);
            $domains = explode(PHP_EOL, $content);
            $top = [];
            $others = [];
            foreach ($domains as $domain) {
                if (str_contains($domain, '.top')) {
                    $top[] = $domain;
                } else {
                    $others[] = $domain;
                }
            }
            file_put_contents('domain_type/top.txt', implode(PHP_EOL, $top), FILE_APPEND);
            file_put_contents('domain_type/others.txt', implode(PHP_EOL, $others), FILE_APPEND);
        }
    }
}
