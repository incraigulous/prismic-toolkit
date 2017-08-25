<?php

namespace Incraigulous\PrismicToolkit\Providers;

use Incraigulous\PrismicToolkit\Cachers\LaravelTaggedCacher;
use Illuminate\Support\ServiceProvider;
use Incraigulous\PrismicToolkit\Console\Sync;
use Prismic\Api;

/**
 * Class PrismicServiceProvider
 * @package Incraigulous\PrismicToolkit\Providers
 */
class PrismicServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //Register the config
        $this->publishes([
            __DIR__.'/../../config/prismic.php' => config_path('prismic.php'),
        ], 'config');

        //Register the migrations
        $this->publishes([
            __DIR__.'/../../database/migrations/' => database_path('migrations')
        ], 'migrations');

        //Register the commands
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
        //Register the official prismic SDK
        $this->app->singleton('prismic', function ($app) {
            return Api::get(
                config('prismic.endpoint'),
                config('prismic.token'),
                null,
                (config('prismic.cacher')) ? new LaravelTaggedCacher() : null,
                config('prismic.cacheTime')
            );
        });

        //Merge the config instead of replacing
        $this->mergeConfigFrom(
            __DIR__.'/../../config/prismic.php', 'prismic'
        );

        //Register migrations
        $this->loadMigrationsFrom(
            __DIR__.'/../../database/migrations/'
        );
    }

    /**
     * @return array
     */
    public function provides()
    {
        return ['prismic'];
    }
}
