<?php

namespace Den1n\NovaPages;

use Den1n\NovaPages\Models\Page;

class Controller extends \App\Http\Controllers\Controller
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
        if (!$page->is_published) {
            abort(404);
        }

        return $page;
    }
}
