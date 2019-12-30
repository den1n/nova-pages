<?php

namespace Den1n\NovaPages;

use Den1n\NovaPages\Models\Page;
use Illuminate\Contracts\Support\Renderable;

class PageController extends \App\Http\Controllers\Controller
{
    /**
     * Shows a page content.
     */
    public function show(Page $page): Renderable
    {
        if ($page->is_published or ($user = auth()->user() and $user->can('pagesManager'))) {
            return view('nova-pages::templates.' . $page->template, [
                'page' => $page,
            ]);
        } else
            abort(404);
    }
}
