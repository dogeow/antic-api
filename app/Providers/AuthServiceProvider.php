<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        ResetPassword::createUrlUsing(function ($notifiable, $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        Sanctum::authenticateAccessTokensUsing(
            static function (PersonalAccessToken $accessToken, bool $isValid) {
                if ($accessToken->name === 'week') { // 访客、临时用户
                    return $isValid && $accessToken->created_at->addWeeks(1) >= now();
                }

                if ($accessToken->name === 'month') { // 用户登录默认
                    return $isValid && $accessToken->created_at->addMonths(1) >= now();
                }

                if ($accessToken->name === 'quarter') { // 暂未使用
                    return $isValid && $accessToken->created_at->addMonths(3) >= now();
                }

                return $isValid;
            }
        );
    }
}
