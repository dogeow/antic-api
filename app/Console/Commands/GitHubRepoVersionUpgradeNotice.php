<?php

namespace App\Console\Commands;

use App\Models\GithubStar;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Slack;

class GitHubRepoVersionUpgradeNotice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'github:notice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'GitHub 的仓库版本更新通知';

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
     */
    public function handle()
    {
        $stars = GithubStar::where('updated', 0)->get();

        foreach ($stars as $star) {
            $name = $star['name'];
            $response = Http::get("https://api.github.com/repos/{$name}/releases/latest");

            $resp = $response->json();

            if (preg_match('/[\d.]+/', (string) $resp['tag_name'], $matches) === false) {
                exit;
            }

            $tagName = $matches[0];

            $version = explode('.', (string) $tagName);

            if ($version === []) {
                exit;
            }

            $major = $version[0];
            $minor = $version[1] ?? 0;
            $patch = $version[2] ?? 0;

            if ($star['major'] && $major > $star['major']) {
                $star->updated = 1;
                $star->save();
                Slack::send("{$name}有主版本号更新");
                continue;
            }

            if ($star['minor'] && $minor > $star['minor']) {
                $star->updated = 1;
                $star->save();
                Slack::send("{$name}有次版本号更新");
                continue;
            }

            if ($star['patch'] && $patch > $star['patch']) {
                $star->updated = 1;
                $star->save();
                Slack::send("{$name}有修订号更新");
            }
        }
    }
}
