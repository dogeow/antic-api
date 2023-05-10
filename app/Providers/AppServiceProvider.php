<?php

namespace App\Providers;

use Algolia\AlgoliaSearch\Config\SearchConfig;
use Algolia\AlgoliaSearch\SearchClient;
use Algolia\AlgoliaSearch\Support\UserAgent;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
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
        if ($this->app->isLocal()) {
            $this->app->register(IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (config('services.sql_debug_log')) {
            DB::listen(function ($query): void {
                Log::debug('DB: '.$query->sql.'['.implode(',', $query->bindings).']');
            });
        }

        if (config('services.sql_debug_log')) {
            DB::listen(function ($query) {
                if ($query->time >= 100) {
                    $location = collect(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS))->filter(function ($trace) {
                        if (isset($trace['file'])) {
                            return ! str_contains($trace['file'], 'vendor/');
                        }

                        return false;
                    })->first();

                    $bindings = implode(', ', $query->bindings); // format the bindings as string

                    Log::info("
Sql: $query->sql
Bindings: $bindings
Time: $query->time
File: {$location['file']}
Line: {$location['line']}");
                }
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

        Filament::serving(function () {
            Filament::registerNavigationGroups([
                NavigationGroup::make()
                    ->label('文章')
                    ->icon('heroicon-o-document-text'),
                NavigationGroup::make()
                    ->label('书签')
                    ->icon('heroicon-o-bookmark'),
                NavigationGroup::make()
                    ->label('我自己')
                    ->icon('heroicon-o-user')
                    ->collapsed(),
            ]);
        });
    }
}
