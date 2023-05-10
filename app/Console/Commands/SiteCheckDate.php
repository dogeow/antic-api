<?php

namespace App\Console\Commands;

use App\Models\Site;
use App\Models\SiteCheck;
use App\Models\User;
use App\Notifications\BuildNotification;
use Carbon\Carbon;
use DateTime;
use Exception;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Notification;
use Log;
use Symfony\Component\DomCrawler\Crawler;

class SiteCheckDate extends Command
{
    /**
     * 超时时间，单位：秒
     * @var string
     */
    final public const TIMEOUT = 30;

    /**
     * 最大延迟更新天数
     */
    public const MAX_DELAY_UPDATE_DAYS = 2;

    /**
     * 是否需要通知
     * @var bool
     */
    public bool $needNotify = false;

    public GuzzleClient $guzzleClient;

    public Crawler $crawler;

    public Site $site;

    /**
     * 是否在线
     * @var bool
     */
    public bool $isOnline;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'site:check {--failed} {--domain=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '用接口或爬虫获取站点更新时间';

    /**
     * HTML 源码
     * @var string
     */
    public string $html = '';

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
        ]);
    }

    /**
     * Execute the console command.
     *
     * @throws GuzzleException
     * @throws Exception
     */
    public function handle(): void
    {
        $checkFailed = $this->option('failed');
        $onlyTheDomain = $this->option('domain');
        if ($checkFailed) {
            $sites = Site::failed()->get();
        } elseif ($onlyTheDomain) {
            $this->info('只检查：'.$onlyTheDomain);
            $sites = Site::where('domain', $onlyTheDomain)->get();
        } else {
            $sites = Site::all();
        }

        foreach ($sites as $site) {
            // 站点是否有更新
            $updateStatus = false;

            $this->site = $site;
            echo $site->domain;

            $date = $this->getIsOnlineAndDate();
            if (! $date) {
                $site->is_online = false;
                echo ' ❌ ';
            } else {
                $site->is_online = $this->isOnline = true;
                if (self::needCheckDate($site)) {
                    $updateStatus = $this->checkDateStatus($date);
                    $this->saveStatus($updateStatus);
                    if (is_string($date)) {
                        $site->last_updated_at = $date;
                    }
                } else { // 没有检查日期的话，HTTP 状态码为 200 不一定是正常的，
                    if ($site->keyword) { // 如果需要匹配是否有包含或者没有包含某个关键字
                        $type = substr($site->keyword, 0, 1);
                        $keyword = substr($site->keyword, 1);
                        $isInclude = str_contains($this->html, $keyword);
                        match ($type) {
                            '+' => $site->is_online = ! $isInclude,
                            '-' => $site->is_online = $isInclude,
                            default => throw new \Exception('关键字格式错误')
                        };
                    }
                }
                echo $site->is_online ? ' ✅ ' : ' ❌ ';
            }

            echo $updateStatus ? ' ✅ ' : ' ❌ ';

            $site->is_new = $updateStatus;
            $site->save();

            echo PHP_EOL;
        }

        // 重新检查一遍失败的
        if ($checkFailed === false && $onlyTheDomain === false) {
            Artisan::call('site:check', ['--failed' => true]);
        }
    }

    /**
     * @throws GuzzleException
     */
    public function getIsOnlineAndDate(): bool|string
    {
        $site = $this->site;

        // api 或者爬虫
        $url = $site->get_type === 'api' ? $site->domain.$site->path : $site->domain;

        try {
            $response = $this->guzzleClient->request('GET', $url);
        } catch (Exception  $e) {
            // 跳过证书 CA 不被信任
            if (str_contains($e->getMessage(), 'unable to get local issuer certificate')) {
                echo '证书不被信任'.PHP_EOL;

                $client = new GuzzleClient([
                    'timeout' => self::TIMEOUT,
                    'verify' => false,
                ]);
                $response = $client->request('GET', $url);
            } else {
                echo $e->getMessage().PHP_EOL;
                Log::info($e->getMessage());

                return false;
            }
        }

        $this->html = $response->getBody()->getContents();
        $crawler = new Crawler($this->html);

        // API
        if ($site->get_type === 'api') {
            return $crawler->text();
        }

        // 爬虫
        if (self::needCheckDate($site)) {
            try {
                return $crawler->filterXPath($site->date_xpath)->text();
            } catch (Exception) {
                return false;
            }
        } else {
            return $response->getStatusCode() === 200;
        }
    }

    public function checkDateStatus($date): bool
    {
        $status = false;
        $dataTime = new DateTime();

        if (is_array($date)) {
            echo '是数组';
            print_r('$date');
            foreach ($date as $dateItem) {
                $targetDate = $dataTime::createFromFormat($this->site->date_format, $dateItem);
                $diff = Carbon::now()->diffInDays($targetDate);
                if ($diff <= self::MAX_DELAY_UPDATE_DAYS) {
                    $status = true;
                    break;
                }
            }
        } else {
            $targetDate = $dataTime::createFromFormat($this->site->date_format ?? 'Y-m-d H:i:s', $date);
            if ($targetDate === false) {
                return false;
            }

            $diff = Carbon::now()->diffInDays($targetDate);
            if ($diff <= self::MAX_DELAY_UPDATE_DAYS) {
                $status = true;
            } else {
                if ($this->needNotify && $this->isOnline) {
                    Notification::send(new User(), new BuildNotification($this->site->domain.' 超过两天'));
                }
            }
        }

        return $status;
    }

    /**
     * 保存状态
     * @param  bool  $status
     * @return void
     */
    public function saveStatus(bool $status): void
    {
        SiteCheck::create([
            'site_id' => $this->site->id,
            'status' => $status,
        ]);
    }

    /**
     * 是否需要检查时间
     * @param  Site  $site
     * @return bool
     */
    public static function needCheckDate(Site $site): bool
    {
        return $site->date_xpath || $site->path;
    }
}
