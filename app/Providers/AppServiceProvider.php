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
            return $user->hasAnyRole(['admin', 'front_office', 'nurse', 'doctor', 'pharmacist', 'lab_technician', 'radiologist']);
        });

        Gate::define('manage-appointments', function ($user) {
            return $user->hasAnyRole(['admin', 'doctor', 'front_office', 'nurse']);
        });

        Gate::define('view-medical-records', function ($user) {
            return $user->hasAnyRole(['admin', 'doctor', 'nurse']);
        });

        Gate::define('manage-vital-signs', function ($user) {
            return $user->hasAnyRole(['admin', 'nurse', 'doctor']);
        });

        Gate::define('view-laboratory', function ($user) {
            return $user->hasAnyRole(['admin', 'doctor', 'lab_technician', 'nurse']);
        });

        Gate::define('view-radiology', function ($user) {
            return $user->hasAnyRole(['admin', 'doctor', 'radiologist', 'nurse']);
        });

        Gate::define('view-pharmacy', function ($user) {
            return $user->hasAnyRole(['admin', 'doctor', 'pharmacist', 'nurse']);
        });

        Gate::define('manage-pharmacy', function ($user) {
            return $user->hasAnyRole(['admin', 'pharmacist']);
        });

        Gate::define('view-billing', function ($user) {
            return $user->hasAnyRole(['admin', 'front_office', 'cashier', 'doctor']);
        });

        Gate::define('manage-inpatient', function ($user) {
            return $user->hasAnyRole(['admin', 'nurse', 'doctor']);
        });

        Gate::define('manage-master-data', function ($user) {
            return $user->hasRole('admin');
        });

        // Share cart count with navbar
        \Illuminate\Support\Facades\View::composer('components.navbar', function ($view) {
            $count = 0;
            if (\Illuminate\Support\Facades\Auth::check()) {
                $cart = \App\Models\Cart::where('user_id', \Illuminate\Support\Facades\Auth::id())->first();
            } else {
                $cart = \App\Models\Cart::where('session_id', \Illuminate\Support\Facades\Session::getId())->first();
            }
            
            if ($cart) {
                $count = $cart->items()->count();
            }
            
            $view->with('cartCount', $count);
        });
    }
}
