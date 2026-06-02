<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Providers\CustomUserProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    // public function boot(): void
    // {
    //     //
    // }
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isSuperAdmin', [\App\Policies\ManagementPolicy::class, 'isSuperAdmin']);

        Auth::provider('custom', function ($app, array $config) {
            return new CustomUserProvider();
        });
    }
}
