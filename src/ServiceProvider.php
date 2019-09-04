<?php

namespace Den1n\NovaPages;

use Illuminate\Support\Collection;
use Illuminate\Filesystem\Filesystem;
use Laravel\Nova\Nova;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(Filesystem $fs): void
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

        $this->loadJSONTranslationsFrom(__DIR__ . '/../resources/lang', 'nova-pages');

        Nova::translations(
            resource_path('lang/vendor/den1n/nova-pages/' . app()->getLocale() . '.json'),
        );

        Nova::resources([
            config('pages.resource'),
        ]);
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/pages.php', 'pages');
    }
}
