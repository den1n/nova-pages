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
        $resource = config('nova-pages.resource');
        if ($resource == PageResource::class) {
            Nova::resources([
                $resource,
            ]);
        }

    }
}
