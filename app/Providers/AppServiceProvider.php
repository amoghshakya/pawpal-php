<?php

namespace App\Providers;

use App\Models\Pet;
use App\Models\User;
use App\Policies\PetPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        Gate::policy(Pet::class, PetPolicy::class);
        Gate::policy(User::class, UserPolicy::class);
    }
}
