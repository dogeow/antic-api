<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Nesk\Puphpeteer\Puppeteer;

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
    protected $description = '无头浏览器';

    protected string $url;
    protected int $time = 3000;
    protected int $width = 450;
    protected int $height = 900;

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
     * @return void
     */
    public function handle()
    {
        $this->url = 'https://233.sx';
        $this->spider();
    }

    public function spider(): void
    {
        $puppeteer = new Puppeteer();
        $browser = $puppeteer->launch([
            'args' => ['--no-sandbox', '--disable-setuid-sandbox'],
        ]);

        $page = $browser->newPage();
        $page->emulate([
            'viewport' => [
                'isMobile' => true, 'width' => $this->width, 'height' => $this->height, 'deviceScaleFactor' => 2,
            ],
            'userAgent' => 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.120 Mobile Safari/537.36',
        ]);

        $page->goto($this->url);
        $page->waitFor($this->time);
        $page->screenshot(['path' => './233.png']);
//        $html = $page->content();

        $browser->close();
    }
}
