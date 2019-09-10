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
        $resource = config('nova-pages.resources.page');
        $resource::$model = config('nova-pages.models.page');
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
            'uriKey' => config('nova-pages.resources.page')::uriKey(),
        ]);
	}
}
