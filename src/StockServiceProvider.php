<?php

namespace Appstract\Stock;

use Illuminate\Support\ServiceProvider;

class StockServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../database/migrations' => database_path('migrations'),
            ], 'migrations');

            $this->publishes([
                __DIR__ . '/../config' => config_path()
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        //
    }
}
