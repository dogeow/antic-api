<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Jobs\ProcessGithubWebHook;
use Illuminate\Http\Request;

class GitHubController extends Controller
{
    public function __invoke(Request $request)
    {
        $secret = config('services.github.web_hook_secret');
        $path = config('services.github.web_hook_path');
        $cmdArray = [
            'cd '.$path,
            'git reset --hard origin/master',
            'git clean -f',
            'git pull',
            'npm install',
            'cross-env NODE_ENV=production node_modules/webpack/bin/webpack.js --no-progress --hide-modules --config=node_modules/laravel-mix/setup/webpack.config.js',
        ];
        $build = implode(' && ', $cmdArray);
        $pull = implode(' && ', array_slice($cmdArray, 0, -2));

        $rawPost = $request->getContent();
        $arrayPost = json_decode($rawPost, true, 512, JSON_THROW_ON_ERROR);
        [$algo, $hash] = explode('=', $request->header('X-Hub-Signature'), 2);

        if (hash_equals($hash, hash_hmac($algo, $rawPost, (string) $secret))) {
            $isBuild = false;
            foreach ($arrayPost['head_commit']['modified'] as $key => $value) {
                if (str_starts_with((string) $value, 'resources/')) {
                    $isBuild = true;
                    break;
                }
            }
            $cmd = $isBuild ? $build : $pull;
            ProcessGithubWebhook::dispatch($cmd);

            return $cmd;
        }

        return http_response_code(404);
    }
}
