<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Observers\CourseObserver;
use App\Models\Course;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Course::observe(CourseObserver::class);

        \View::composer('*', function ($view) {
            $user = \Auth::user();
            $subscribed = $user && ($user->isSubscribed || $user->hasRole('admin'));
            
            $view->with('subscribed', $subscribed)->with('user', $user);
        });
    }
}
