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
        PageResource::$model = config('nova-pages.model');

        $resource = config('nova-pages.resource');
        if ($resource == PageResource::class) {
            Nova::resources([
                $resource,
            ]);
        }

    }

	/**
	 * Build the view that renders the navigation links for the tool.
	 */
	public function renderNavigation()
	{
		return view('nova-pages::navigation', [
            'uriKey' => config('nova-pages.resource')::uriKey(),
        ]);
	}
}
