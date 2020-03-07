<?php

namespace App\Console\Commands;

use App\Models\Site;
use App\Models\SiteCheck;
use Carbon\Carbon;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;

class SiteCheckData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spider:date {--failed}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public $guzzleClient;
    public $crawler;
    public $site;

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
     *
     * @return mixed
     */
    public function handle()
    {
        $checkFailed = $this->option('failed');
        if ($checkFailed) {
            $failed = Site::with('todayLatest')->get()->filter(function ($site) {
                return $site->online === 0 || $site->todayLatest->status === 0;
            });
        }

        $sites = $failed ?? Site::all();

        foreach ($sites as $key => $site) {
            $this->site = $site;
            echo $site->domain.PHP_EOL;
            $date = $this->getDate();
            if ($date === false) {
                $site->online = false;
                $site->save();
            } else {
                $status = $this->checkDateStatus($date);
                $this->saveStatus($status);
                $site->online = true;
                $site->save();
            }
        }
    }

    public function getDate()
    {
        if ($this->site->get_type === 'api') {
            $url = $this->site->domain.'/api/date';
        } else {
            $url = $this->site->domain;
        }

        try {
            $response = $this->guzzleClient->request('GET', $url);
        } catch (\Exception  $e) {
            return false;
        }

        $crawler = new Crawler($response->getBody()->getContents());

        if ($this->site->get_type === 'api') {
            $date = $crawler->text();
        } else {
            $date = $crawler->filterXPath($this->site->date_xpath)->text();
        }

        return $date;
    }

    public function saveStatus($status)
    {
        SiteCheck::create([
            'site_id' => $this->site->id,
            'status' => $status,
        ]);
    }

    public function checkDateStatus($date)
    {
        $status = false;
        $dataTime = new \DateTime;

        if (is_array($date)) {
            foreach ($date as $key => $dateItem) {
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
            $status = $diff ? false : true;
        }

        return $status;
    }
}
