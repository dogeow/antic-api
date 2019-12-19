<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Nesk\Puphpeteer\Puppeteer;
use Nesk\Rialto\Data\JsFunction;

class Headless extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'headless';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $time = 3000;
    protected $url;
    protected $width = 450;
    protected $height = 900;

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
     *
     * @return mixed
     */
    public function handle()
    {
        $this->url = "https://www.learnku.com";
        self::spider();
    }

    public function spider()
    {
        $puppeteer = new Puppeteer();
        $browser = $puppeteer->launch([
            'args' => ['--no-sandbox', '--disable-setuid-sandbox'],
        ]);

        $page = $browser->newPage();
        $page->emulate([
            'viewport' => [
                'isMobile' => true, 'width' => $this->width, 'height' => $this->height, 'deviceScaleFactor' => 2
            ],
            'userAgent' => 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.120 Mobile Safari/537.36'
        ]);

        $page->goto($this->url);
        $page->waitFor($this->time);
        $page->screenshot(['path' => './233.png']);
//        $html = $page->content();

        $browser->close();
    }
}
