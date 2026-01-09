<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
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
        // Define Gates for role-based permissions
        Gate::define('manage-patients', function ($user) {
            return $user->hasAnyRole(['admin', 'front_office', 'management']);
        });

        Gate::define('manage-appointments', function ($user) {
            return $user->hasAnyRole(['admin', 'doctor', 'front_office']);
        });

        Gate::define('view-medical-records', function ($user) {
            return $user->hasAnyRole(['admin', 'doctor', 'nurse']);
        });

        Gate::define('view-laboratory', function ($user) {
            return $user->hasAnyRole(['admin', 'doctor', 'lab_technician']);
        });

        Gate::define('view-radiology', function ($user) {
            return $user->hasAnyRole(['admin', 'doctor', 'radiologist']);
        });

        Gate::define('view-pharmacy', function ($user) {
            return $user->hasAnyRole(['admin', 'doctor', 'pharmacist']);
        });

        Gate::define('view-billing', function ($user) {
            return $user->hasAnyRole(['admin', 'front_office', 'cashier']);
        });

        Gate::define('manage-master-data', function ($user) {
            return $user->hasRole('admin');
        });
    }
}
