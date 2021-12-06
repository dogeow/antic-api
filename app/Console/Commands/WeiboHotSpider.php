<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\WeiboHot;
use App\Models\WeiboToTop;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;

class WeiboHotSpider extends Command
{
    public const TIMEOUT = 30;

    public GuzzleClient $guzzleClient;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weibo:hot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '爬微博热搜榜';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->guzzleClient = new GuzzleClient([
            'timeout' => self::TIMEOUT,
            'headers' => [
                'Cookie' => 'login_sid_t=94eb15418d380f172601d0713b255b6f; cross_origin_proto=SSL; _s_tentry=passport.weibo.com; Apache=9304519184780.479.1629036803787; SINAGLOBAL=9304519184780.479.1629036803787; ULV=1629036803793:1:1:1:9304519184780.479.1629036803787:; SSOLoginState=1629036850; SUBP=0033WrSXqPxfM725Ws9jqgMF55529P9D9Wh_CnP7FrSm0UyUnLDEZX.S5JpX5KMhUgL.Fo2R1hqRSh-R1hB2dJLoIEBLxKML12eLB-zLxKML12zL1KMLxK-L1h-L1KBLxK-LB-BL1K5t; ALF=1667464173; SCF=AvsBt0VZMm9jEIdbbqz7vtOaxraoyDs5iprwMcJNe9XulU9aFhvRX9XNsfX3TMH7IXMYmJ0KgVLocJItJa25FlY.; SUB=_2A25Mhjg-DeRhGedG41QZ9CvEwziIHXVv8i72rDV8PUNbmtB-LVKjkW9NURz4_iXRVfZALFMEU87ZMAwQLe7MzKYy; UOR=,,login.sina.com.cn',
            ],
        ]);
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $response = $this->guzzleClient->request('GET', 'https://s.weibo.com/top/summary');
        $html = $response->getBody()->getContents();
        $htmlNoBlank = preg_replace("/>\n\s*/i", '>', $html);
        preg_match('/td-02.*?="(.*?)".*?>(.*?)<\/a>.*?<i.*?>(.*?)<\/i>/si', $htmlNoBlank, $topping);
        $deleteTopping = preg_replace('/<tbody.*?<\/tr>/i', '', $htmlNoBlank);
        $pattern = "/td-02.*?><a.*?href=\"(.*?)\".*?>(.*?)<\/a><span>(.*?)<\/span>.*?td-03.*?>(.*?)<\/td>/i";
        preg_match_all($pattern, $deleteTopping, $matches, PREG_SET_ORDER);

        // 置顶条目
        $toppingData = [
            'title' => $topping[2],
            'url' => $topping[1],
            'status' => status($topping[3]),
        ];

        if (! WeiboToTop::where('title', $toppingData['title'])->exists()) {
            try {
                WeiboToTop::create($toppingData);
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                echo $errorCode;
            }
        }

        // 前50
        foreach ($matches as $i) {
            $url = $i[1];
            if ($url === 'javascript:void(0);') {
                continue;
            }

            $tmp = explode(' ', $i[3]);
            if (count($tmp) === 1) {
                $rank = $i[3];
            } else {
                $rank = $tmp[2];
            }

            $title = $i[2];
            $status = $i[4] ?? null;

            if (preg_match('/<img.*?>/i', $i[0], $emojiMatches)) {
                $emoji = $emojiMatches[0];
            } else {
                $emoji = null;
            }

            if ($status && preg_match("/<i.*?>(.*?)<\/i>/i", $i[4], $statusMatches)) {
                $status = $statusMatches[1];
            }

            $updateData = [
                'rank' => $rank,
                'emoji' => $emoji,
                'status' => status($status),
                'url' => $url,
            ];

            WeiboHot::updateOrCreate(['title' => $title], $updateData);
        }
    }
}
