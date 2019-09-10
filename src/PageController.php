<?php

namespace Den1n\NovaPages;

use Illuminate\Contracts\Support\Renderable;

class PageController extends \App\Http\Controllers\Controller
{
    /**
     * Shows a page content.
     */
    public function show(Page $page): Renderable
    {
        if (auth()->user()->can('pagesManager') || $page->published) {
            return view('nova-pages::templates.' . $page->template, [
                'page' => $page,
            ]);
        } else
            abort(404);
    }
}
