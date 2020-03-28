<?php

namespace App\Providers;

use App\Utils\Oss;
use Illuminate\Support\ServiceProvider;

class OssServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('OSS', 'App\Utils\Oss');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
