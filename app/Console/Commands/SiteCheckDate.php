<?php

declare(strict_types=1);

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
     *
     * @var string
     */
    final public const TIMEOUT = 30;

    public const MAX_DELAY_UPDATE_DAYS = 2;

    /**
     * 是否需要通知
     * @var bool
     */
    public bool $needNotify = false;

    public GuzzleClient $guzzleClient;

    public Crawler $crawler;

    public Site $site;

    public bool $isOnline;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spider:date {--failed} {--domain=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '用接口或爬虫获取站点更新时间';
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
    public function handle()
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
            if ($date) {
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
            } else {
                $site->is_online = false;
                echo ' ❌ ';
            }

            echo $updateStatus ? ' ✅ ' : ' ❌ ';

            $site->is_new = $updateStatus;
            $site->save();

            echo PHP_EOL;
        }

        // 重新检查一遍失败的
        if ($checkFailed === false && $onlyTheDomain === false) {
            Artisan::call('spider:date', ['--failed' => true]);
        }
    }

    /**
     * @throws GuzzleException
     */
    public function getIsOnlineAndDate(): bool|string
    {
        $site = $this->site;

        $url = $site->get_type === 'api' ? $site->domain.$site->path : $site->domain;

        try {
            $response = $this->guzzleClient->request('GET', $url);
        } catch (Exception  $e) {
            // 跳过证书 CA 不被信任
            if (str_contains($e->getMessage(), 'unable to get local issuer certificate')) {
                $client = new GuzzleClient([
                    'timeout' => self::TIMEOUT,
                    'verify' => true,
                ]);
                $response = $client->request('GET', $url);
            } else {
                Log::info($e->getMessage());

                return false;
            }
        }

        $this->html = $response->getBody()->getContents();
        $crawler = new Crawler($this->html);

        if ($site->get_type === 'api') {
            $date = $crawler->text();
        } else {
            if (self::needCheckDate($site)) {
                try {
                    $date = $crawler->filterXPath($site->date_xpath)->text();
                } catch (Exception) {
                    return false;
                }
            } else {
                return $response->getStatusCode() === 200;
            }
        }

        return $date;
    }

    public function checkDateStatus($date): bool
    {
        $status = false;
        $dataTime = new DateTime();

        if (is_array($date)) {
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

    public function saveStatus($status): void
    {
        SiteCheck::create([
            'site_id' => $this->site->id,
            'status' => $status,
        ]);
    }

    /**
     * 是否检查时间
     */
    public static function needCheckDate($site): bool
    {
        return $site->date_xpath || $site->path;
    }
}
