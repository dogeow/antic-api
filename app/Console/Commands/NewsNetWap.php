<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class NewsNetWap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:net-wap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '爬新闻标题';

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
     * @return int
     */
    public function handle()
    {
        $url = 'https://3g.163.com/touch/reconstruct/article/list/BBM54PGAwangning/1-10.html';
        $content = file_get_contents($url);
        $json = substr($content, 9, -1);
        $array = json_decode($json, true);

        $news = [];
        foreach ($array['BBM54PGAwangning'] as $item) {
            $news[] = [
                'title' => $item['title'],
            ];

            \DB::table('news')->insertOrIgnore($news);
        }
    }
}
