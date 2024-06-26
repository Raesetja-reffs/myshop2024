<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\CentralUser;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Policies\CompanyPermissionPolicy;
use App\Models\CompanyPermission;
use App\Policies\CentralUserPolicy;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::policy(CompanyPermission::class, CompanyPermissionPolicy::class);
        Gate::policy(CentralUser::class, CentralUserPolicy::class);
    }
}
