<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use Illuminate\Support\Facades\Route;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // add passport routes
        Route::group([
            'middleware' => ['passportCustomProvider']], function () {
            Passport::routes();

        });

        // config token expired days
        Passport::tokensExpireIn(now()->addDays(15));

//        // config refresh token expire
//        Passport::refreshTokensExpireIn(now()->addDays(30));

    }
}
