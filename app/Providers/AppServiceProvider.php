<?php

namespace App\Providers;

use App\Models\Tenants\Blog;
use App\Models\User;
use App\Policies\TenantPolicy;
use App\Policies\Tenants\BlogPolicy;
use App\Policies\Tenants\UserPolicy;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Passport::loadKeysFrom(storage_path());
        Gate::policy(Blog::class, BlogPolicy::class);
        Gate::define('create-tenant', [TenantPolicy::class, 'create']);
  
    }
}
