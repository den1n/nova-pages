<?php

namespace Den1n\NovaPages;

use Laravel\Nova\Nova;

class Tool extends \Laravel\Nova\Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     */
    public function boot(): void
    {
        Nova::script('nova-pages', __DIR__ . '/../dist/nova.js');

        $page = config('nova-pages.resources.page');

        $page::$model = config('nova-pages.models.page');

        Nova::resources([
            $page
        ]);
    }
}
