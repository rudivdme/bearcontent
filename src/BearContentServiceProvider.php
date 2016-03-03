<?php

namespace Rudivdme\BearContent;

use Illuminate\Support\ServiceProvider;
use Blade;

class BearContentServiceProvider extends ServiceProvider
{
     protected $commands = [
        'Rudivdme\BearContent\Commands\Pages',
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if (! $this->app->routesAreCached()) {
            require __DIR__.'/routes.php';
        }

        $this->loadTranslationsFrom( __DIR__.'/../resources/lang', 'bear');

        $this->loadViewsFrom( __DIR__.'/../resources/views', 'bear');

        $this->publishes([
            __DIR__.'/../config/bear.php' => config_path('bear.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations')
        ], 'migrations');

        $this->publishes([
            __DIR__.'/../database/seeds/' => database_path('seeds')
        ], 'seeds');

        $this->publishes([
            __DIR__.'/../resources/assets/build/' => public_path('vendor/bear')
        ], 'public');

        /*
        $this->publishes([
            __DIR__.'/../resources/assets/views/' => public_path('vendor/bear')
        ], 'public');
        */
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom( __DIR__.'/../config/bear.php', 'bear');

        $this->app['bear'] = $this->app->share(function($app) {
            return new BearContent;
        });

        $this->commands($this->commands);
    }
}
