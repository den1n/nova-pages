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
        PageResource::$model = config('pages.model');

        $this->publishes([
            __DIR__ . '/../config/pages.php' => config_path('pages.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../migrations' => database_path('migrations'),
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/den1n/nova-pages'),
        ], 'lang');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/nova-pages'),
        ], 'views');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'nova-pages');
        $this->loadJSONTranslationsFrom(__DIR__ . '/../resources/lang');

        Nova::translations(
            resource_path('lang/vendor/den1n/nova-pages/' . app()->getLocale() . '.json'),
        );

        $resource = config('pages.resource');
        if ($resource == PageResource::class) {
            Nova::resources([
                $resource,
            ]);
        }

        Route::macro('novaPagesRoutes', function () {
            Route::model('page', config('pages.model'));
            Route::group([
                'middleware' => ['web'],
                'namespace' => '\\' . __NAMESPACE__,
            ], function () {
                Route::get('/{page}', 'PageController@index');
            });
        });

        Page::observe(PageObserver::class);
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/pages.php', 'pages');
    }
}
