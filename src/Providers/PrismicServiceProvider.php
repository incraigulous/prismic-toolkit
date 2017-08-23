<?php

namespace Incraigulous\PrismicToolkit\Providers;

use Incraigulous\PrismicToolkit\Cachers\LaravelTaggedCacher;
use Illuminate\Support\ServiceProvider;
use Incraigulous\PrismicToolkit\Console\Sync;
use Prismic\Api;

class PrismicServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'../config/prismic.php' => config_path('prismic.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations')
        ], 'migrations');

        if ($this->app->runningInConsole()) {
            $this->commands([
                Sync::class
            ]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('prismic', function ($app) {
            return Api::get(
                config('prismic.endpoint'),
                config('prismic.token'),
                null,
                (config('prismic.cacher')) ? new LaravelTaggedCacher() : null
            );
        });
    }

    public function provides()
    {
        return ['prismic'];
    }
}
