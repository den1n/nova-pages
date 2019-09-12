<?php

namespace Den1n\NovaPages;

use Illuminate\Support\Str;

class PageObserver
{
    /**
     * Generate unique page slug.
     */
    protected function generateSlug (Page $page): string
    {
        $slug = $page->slug ?: Str::slug($page->name);
        if ($count = config('nova-pages.models.page')::where('id', '!=', $page->id)->where('slug', $slug)->count())
            $slug .= '-' . ($count + 1);
        return $slug;
    }

    /**
     * Handle the Page "saving" event.
     */
    public function saving(Page $page): void
    {
        $page->slug = $this->generateSlug($page);
    }
}
