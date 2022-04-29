<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Horizon\HorizonApplicationServiceProvider;
use Laravel\Sanctum\PersonalAccessToken;

class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        // Horizon::routeSmsNotificationsTo('15556667777');
        // Horizon::routeMailNotificationsTo('example@example.com');
        // Horizon::routeSlackNotificationsTo('slack-webhook-url', '#channel');

        // Horizon::night();
    }

    /**
     * Register the Horizon gate.
     *
     * This gate determines who can access Horizon in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewHorizon', function ($user) {
            $token = PersonalAccessToken::findToken(request()->token);
            $tokenUser = $token->tokenable;

            return $tokenUser->email === 'lky216@gmail.com';
        });
    }
}
