<?php

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
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (config('services.sql_debug_log')) {
            DB::listen(function ($query) {
                Log::debug('DB: '.$query->sql.'['.implode(',', $query->bindings).']');
            });
        }

        $this->app->resolving(EngineManager::class, function ($engine, $app) {
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
