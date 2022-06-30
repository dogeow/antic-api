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
use Illuminate\Support\Facades\Notification;
use Log;
use Symfony\Component\DomCrawler\Crawler;

class SiteCheckDate extends Command
{
    final public const TIMEOUT = 30;

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
    protected $description = '用接口获取站点更新时间';

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
     */
    public function handle(): void
    {
        $checkFailed = $this->option('failed');
        $onlyTheDomain = $this->option('domain');
        if ($checkFailed) {
            $sites = Site::whereNotNull('get_type')->with('todayLatest')->get()->filter(fn($site) => $site->online === 0 || (property_exists($site->todayLatest, 'status') && $site->todayLatest->status !== null && $site->todayLatest->status === 0));
        } elseif ($onlyTheDomain) {
            $sites = Site::whereNotNull('get_type')->where('domain', $onlyTheDomain)->get();
        } else {
            $sites = Site::whereNotNull('get_type')->get();
        }

        foreach ($sites as $site) {
            $status = false;

            $this->site = $site;
            echo $site->domain;
            $date = $this->getDate();
            if ($date) {
                $site->online = $this->isOnline = true;
                $status = $this->checkDateStatus($date);
                $this->saveStatus($status);
                $site->last_updated_at = $date;
                echo ' ✅ ';
            } else {
                $site->online = false;
                echo ' ❌ ';
            }

            echo $status ? ' ✅ ' : ' ❌ ';

            $site->save();

            echo PHP_EOL;
        }
    }

    /**
     * @throws GuzzleException
     */
    public function getDate(): bool|string
    {
        $site = $this->site;

        $url = $site->get_type === 'api' ? $site->domain.$site->path : $site->domain;

        try {
            $response = $this->guzzleClient->request('GET', $url);
        } catch (Exception  $e) {
            Log::info($e->getMessage());

            return false;
        }

        $crawler = new Crawler($response->getBody()->getContents());

        if ($site->get_type === 'api') {
            $date = $crawler->text();
        } else {
            try {
                $date = $crawler->filterXPath($site->date_xpath)->text();
            } catch (Exception) {
                return false;
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
                if ($diff <= 2) {
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
            if ($this->needNotify && $this->isOnline && Carbon::now()->diffInMinutes($targetDate) >= 4320) {
                Notification::send(new User(), new BuildNotification($this->site->domain.' 超过三天'));
            }

            if ($diff <= 3) {
                $status = true;
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
}
