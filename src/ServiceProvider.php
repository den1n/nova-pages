<?php

namespace Den1n\NovaPages;

use Illuminate\Support\Facades\Route;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->publishResources();
        $this->loadMigrations();
        $this->loadTranslations();
        $this->loadRoutes();
        $this->loadViews();
    }

    /**
     *  Publish package resources.
     */
    protected function publishResources(): void
    {
        $this->publishes([
            __DIR__ . '/../config' => config_path(),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../migrations' => database_path('migrations'),
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/nova-pages'),
        ], 'lang');

        $this->publishes([
            __DIR__ . '/../resources/js/frontend' => resource_path('js/vendor/nova-pages'),
        ], 'example');
    }

    /**
     * Load package migrations files.
     */
    protected function loadMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');
    }

    /**
     *  Load package translation files.
     */
    protected function loadTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'nova-pages');
        $this->loadJSONTranslationsFrom(__DIR__ . '/../resources/lang');
        $this->loadJsonTranslationsFrom(resource_path('lang/vendor/nova-pages'));
    }

    /**
     *  Load package routes.
     */
    protected function loadRoutes(): void
    {
        Route::macro('novaPages', function () {
            Route::name('nova-pages.')->group(function () {
                $controller = '\\' . ltrim(config('nova-pages.controller'), '\\');

                Route::apiResource('vendor/nova-pages/page', $controller)->only('show');
            });
        });
    }

    /**
     *  Load package views.
     */
    protected function loadViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'nova-pages');
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/nova-pages.php', 'nova-pages');
    }
}
