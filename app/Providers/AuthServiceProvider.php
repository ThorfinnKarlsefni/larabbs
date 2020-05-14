<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use Carbon\Carbon;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
		'App\Model' => 'App\Policies\ModelPolicy',
        \App\Models\User::class => \App\Policies\UserPolicy::class,
        \App\Models\Reply::class => \App\Policies\ReplyPolicy::class,
        \App\Models\Topic::class => \App\Policies\TopicPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //Passprot 路由
        Passport::routes();
        //accessToken 过期时间
        Passport::tokensExpireIn(Carbon::now()->addDays(15));
        //refreshTokens 过期时间
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));

        \Horizon::auth(function ($request) {
            // 是否是站长
            return \Auth::user()->hasRole('Founder');
        });
    }
}