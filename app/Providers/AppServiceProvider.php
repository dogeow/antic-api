<?php

declare(strict_types=1);

namespace App\Providers;

use Algolia\AlgoliaSearch\Config\SearchConfig;
use Algolia\AlgoliaSearch\SearchClient;
use Algolia\AlgoliaSearch\Support\UserAgent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Laravel\Scout\EngineManager;
use Laravel\Scout\Engines\AlgoliaEngine;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('services.sql_debug_log')) {
            DB::listen(function ($query): void {
                Log::debug('DB: '.$query->sql.'['.implode(',', $query->bindings).']');
            });
        }

        if (config('services.sql_debug_log')) {
            DB::listen(function ($query) {
                $location = collect(debug_backtrace())->filter(function ($trace) {
                    if (isset($trace['file'])) {
                        return !str_contains($trace['file'], 'vendor/');
                    }

                    Log::info(var_export($trace, true));

                    return true;
                })->first(); // grab the first element of non vendor/ calls

                $bindings = implode(", ", $query->bindings); // format the bindings as string

                Log::info("
                ------------
                Sql: $query->sql
                Bindings: $bindings
                Time: $query->time
                File: ${location['file']}  ?? null};
                Line: ${location['line']}
                ------------
            ");
            });
        }

        $this->app->resolving(EngineManager::class, function ($engine, $app): void {
            $engine->extend('algolia', function () {
                UserAgent::addCustomUserAgent('Laravel Scout', '8.6');
                $config = SearchConfig::create(config('scout.algolia.id'), config('scout.algolia.secret'));
                $config->setConnectTimeout(30);
                $config->setReadTimeout(30);
                $config->setWriteTimeout(30);

                return new AlgoliaEngine(
                    SearchClient::createWithConfig($config),
                    config('scout.soft_delete')
                );
            });
        });
    }
}
