<?php

namespace Den1n\NovaPages;

use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\Facades\Route;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->publishResources();
        $this->loadTranslations();
        $this->loadRoutes();

        Nova::serving(function (ServingNova $event) {
            Nova::script('nova-pages-fields', __DIR__ . '/../dist/fields.js');
            Nova::style('nova-pages-fields', __DIR__ . '/../dist/fields.css');
        });

        config('nova-pages.models.page')::observe(Observers\Page::class);
    }

    /**
     *  Publish package resources.
     */
    protected function publishResources(): void
    {
        $this->publishes([
            __DIR__ . '/../config/nova-pages.php' => config_path('nova-pages.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../migrations' => database_path('migrations'),
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/nova-pages'),
        ], 'lang');

        $this->publishes([
            __DIR__ . '/../resources/views/templates' => resource_path('views/vendor/nova-pages/templates'),
        ], 'views');

        $this->publishes([
            __DIR__ . '/../dist' => public_path('vendor/nova-pages'),
        ], 'public');
    }

    /**
     *  Load package translation files.
     */
    protected function loadTranslations(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'nova-pages');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'nova-pages');
        $this->loadJSONTranslationsFrom(__DIR__ . '/../resources/lang');
        $this->loadJsonTranslationsFrom(resource_path('lang/vendor/nova-pages'));
    }

    /**
     *  Load package routes.
     */
    protected function loadRoutes(): void
    {
        Route::macro('novaPagesRoutes', function (string $prefix = '') {
            Route::model('page', config('nova-pages.models.page'));
            Route::group([
                'prefix' => $prefix,
                'middleware' => ['web'],
                'namespace' => '\\' . __NAMESPACE__,
            ], function () {
                $controller = '\\' . ltrim(config('nova-pages.controller.class'), '\\');
                Route::get('/{page}', $controller . '@show')->name('nova-pages.show');
            });
        });
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/nova-pages.php', 'nova-pages');
    }
}
