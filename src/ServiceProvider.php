<?php

namespace Den1n\NovaPages;

use Laravel\Nova\Nova;
use Illuminate\Support\Facades\Route;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        PageResource::$model = config('nova-pages.model');

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
            __DIR__ . '/../resources/views' => resource_path('views/vendor/nova-pages'),
        ], 'views');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'nova-pages');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'nova-pages');
        $this->loadJSONTranslationsFrom(__DIR__.'/../resources/lang');
        $this->loadJsonTranslationsFrom(resource_path('lang/vendor/nova-pages'));

        $resource = config('nova-pages.resource');
        if ($resource == PageResource::class) {
            Nova::resources([
                $resource,
            ]);
        }

        Route::macro('novaPagesRoutes', function (string $prefix = '') {
            Route::model('page', config('nova-pages.model'));
            Route::group([
                'prefix' => $prefix,
                'middleware' => ['web'],
                'namespace' => '\\' . __NAMESPACE__,
            ], function () {
                Route::get('/{page}', 'PageController@show')->name('nova-pages.show');
            });
        });

        Page::observe(PageObserver::class);
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/nova-pages.php', 'nova-pages');
    }
}
