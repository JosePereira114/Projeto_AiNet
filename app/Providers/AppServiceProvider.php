<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Course;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
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
        //só os que têm o type na bd a A é que podem aceder
        Gate::define('admin', function (User $user) {
            return $user->type === 'A';
        });

        Gate::define('custumer', function (User $user) {
            return $user->type === 'C';
        });

        Gate::define('employee', function (User $user) {
            return $user->type === 'E';
        });

        
        try {
            // View::share adds data (variables) that are shared through all views (like global data)
            View::share('courses', Course::orderBy('type')->orderBy('name')->get());
        } catch (\Exception $e) {
            // If no Database exists, or Course table does not exist yet, an error will occour
            // This will ignore this error to avoid problems before migration is correctly executed
            // (When executing "composer update", when executing "php artisan migrate", etc)
        }
    }
}
