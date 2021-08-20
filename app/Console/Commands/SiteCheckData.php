<?php

namespace App\Console\Commands;

use App\Models\Site;
use App\Models\SiteCheck;
use App\Models\User;
use App\Notifications\BuildNotification;
use Carbon\Carbon;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\DomCrawler\Crawler;

class SiteCheckData extends Command
{
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

    public GuzzleClient $guzzleClient;
    public Crawler $crawler;
    public Site $site;

    public const TIMEOUT = 30;

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
     * @return void
     * @throws GuzzleException
     */
    public function handle(): void
    {
        $checkFailed = $this->option('failed');
        $onlyTheDomain = $this->option('domain');
        if ($checkFailed) {
            $sites = Site::whereNotNull('get_type')->with('todayLatest')->get()->filter(function ($site) {
                return $site->online === 0;
            });
        } elseif ($onlyTheDomain) {
            $sites = Site::where('domain', $onlyTheDomain)->get();
        } else {
            $sites = Site::all();
        }

        foreach ($sites as $site) {
            $this->site = $site;
            echo $site->domain.PHP_EOL;
            $date = $this->getDate();
            if ($date === false) {
                $site->online = false;
            } else {
                $status = $this->checkDateStatus($date);
                $this->saveStatus($status);
                $site->online = true;
            }
            $site->save();
        }
    }

    /**
     * @return bool|string
     * @throws GuzzleException
     */
    public function getDate(): bool|string
    {
        $site = $this->site;

        $url = $site->get_type === 'api' ? $site->domain.$site->path : $site->domain;

        try {
            $response = $this->guzzleClient->request('GET', $url);
        } catch (\Exception  $e) {
            \Log::info($e->getMessage());

            return false;
        }

        $crawler = new Crawler($response->getBody()->getContents());

        return $site->get_type === 'api' ? $crawler->text() : $crawler->filterXPath($site->date_xpath)->text();
    }

    public function saveStatus($status): void
    {
        SiteCheck::create([
            'site_id' => $this->site->id,
            'status' => $status,
        ]);
    }

    public function checkDateStatus($date): bool
    {
        $status = false;
        $dataTime = new \DateTime;

        if (is_array($date)) {
            foreach ($date as $dateItem) {
                $targetDate = $dataTime::createFromFormat($this->site->date_format, $dateItem);
                $diff = Carbon::now()->diffInDays($targetDate);
                if ($diff === 0) {
                    $status = true;
                    break;
                }
            }
        } else {
            $targetDate = $dataTime::createFromFormat($this->site->date_format, $date);
            if ($targetDate === false) {
                return false;
            }
            $diff = Carbon::now()->diffInDays($targetDate);
            if (Carbon::now()->diffInMinutes($targetDate) >= 1440) {
                Notification::send(new User, new BuildNotification($this->site->domain.' 超过十分钟'));
            }
            $status = !$diff;
        }

        return $status;
    }
}
