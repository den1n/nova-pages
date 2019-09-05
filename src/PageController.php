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
        if ($page->published) {
            return view('nova-pages::' . $page->template, [
                'page' => $page,
            ]);
        } else
            abort(404);
    }
}
