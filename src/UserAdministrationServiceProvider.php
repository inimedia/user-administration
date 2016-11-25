<?php

namespace Inimedia\UserAdministration;

use Illuminate\Support\ServiceProvider as BaseProvider;

class UserAdministrationServiceProvider extends BaseProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        require __DIR__.'/routes.php';
//        if (! $this->app->routesAreCached()) {
//            require __DIR__.'/routes.php';
//        }
        $this->loadViewsFrom(__DIR__ . '/views', 'user-administration');
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->publishes([
//            __DIR__ . '/views' => base_path('resources/views/inimedia/user-administration'),
//            __DIR__.'/config/user-administration.php' => config_path('user-administration.php'),
        ]);
//        $this->publishes([ __DIR__ . '/migrations' => $this->app->databasePath() . '/migrations' ], 'migrations');

//        $this->publishes([
//            __DIR__.'/assets' => public_path('inimedia/user-administration'),
//        ], 'public');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
//        $this->mergeConfigFrom(
//            __DIR__ . '/config/user-administration.php', 'inimedia-user-administration'
//        );
    }
}
