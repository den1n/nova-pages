<?php

namespace Den1n\NovaPages\Controllers;

use Den1n\NovaPages\Models\Page;

class Pages extends \App\Http\Controllers\Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('api');
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page): Page
    {
        if (!$page->shouldBeSearchable()) {
            abort(404);
        }

        return $page;
    }
}
