<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

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
        if ($this->app->isProduction()) {
            URL::forceScheme('https');
        }

        Model::preventLazyLoading(!$this->app->isProduction());

        Password::defaults(fn() => $this->app->isProduction() ? Password::min(8)->mixedCase()->numbers()->symbols() : Password::min(3));

        Blade::if('admin', fn() => request()->user()?->can('admin'));

        Blade::if('user', fn() => request()->user()?->can('user'));
    }
}
