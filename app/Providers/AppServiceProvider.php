<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Auth\Access\Response;
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
        // Allow admin to bypass all gate checks
        Gate::before(function (User $user, string $ability) {
            return $user->role === 'admin' ? true : null;
        });

        Gate::define('admin', function (User $user) {
            return strtolower($user->role) === 'admin'
                ? Response::allow()
                : Response::deny('You must be an administrator.');
        });

        Gate::define('HoD', function (User $user) {
            $role = strtolower($user->role);
            return ($role === 'hod' || $role === 'kajur')
                ? Response::allow()
                : Response::deny('You must be an head of departement.');
        });

        Gate::define('lecturer', function (User $user) {
            return strtolower($user->role) === 'lecturer'
                ? Response::allow()
                : Response::deny('You must be an lecturer.');
        });

        Gate::define('student', function (User $user) {
            return strtolower($user->role) === 'student'
                ? Response::allow()
                : Response::deny('You must be an student.');
        });
    }
}
