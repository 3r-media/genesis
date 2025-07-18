<?php

namespace Rrr\Genesis;

use App\Console\Commands\DynamicRobots;
use Illuminate\Support\ServiceProvider;
use Rrr\Genesis\Console\Commands\DynamicRobotsCommand;
use Rrr\Genesis\Console\Commands\InstallGenesisCommand;
use Rrr\Genesis\Console\Commands\ReadMeUpdateCommand;

class GenesisServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'rrr');
         $this->loadViewsFrom(__DIR__.'/../resources/views', 'rrr');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
         $this->loadRoutesFrom(__DIR__.'/../routes/genesis.php');

        if (!class_exists('Genesis')) {
            class_alias(\Rrr\Genesis\Facades\Genesis::class, 'Genesis');
        }
        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
//        $this->mergeConfigFrom(__DIR__.'/../config/genesis.php', 'genesis');

        // Register the service the package provides.
        $this->app->singleton('genesis', function ($app) {
            return new Genesis;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['genesis'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        $this->publishes([
            __DIR__ . '/../resources/stubs/.gitignore' => base_path('.gitignore'),
        ], 'genesis.stubs');

        // Publishing the configuration file.
//        $this->publishes([
//            __DIR__.'/../config/genesis.php' => config_path('genesis.php'),
//        ], 'genesis.config');

        // Publishing the views.
//        $this->publishes([
//            __DIR__.'/../resources/views' => base_path('resources/views/vendor/rrr'),
//        ], 'genesis.views');

        // Publishing the migrations.
//        $this->publishes([
//            __DIR__.'/../database/migrations' => database_path('migrations'),
//        ], 'genesis.migrations');

        // Publishing assets.
//        $this->publishes([
//            __DIR__.'/../resources/assets' => public_path('vendor/rrr'),
//        ], 'genesis.assets');

        // Publishing the translation files.
//        $this->publishes([
//            __DIR__.'/../resources/lang' => resource_path('lang/vendor/rrr'),
//        ], 'genesis.lang');

        // Registering package commands.
        $this->commands([
            InstallGenesisCommand::class,
            ReadMeUpdateCommand::class,
            DynamicRobotsCommand::class
        ]);
    }
}
