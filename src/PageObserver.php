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
        $counter = 1;
        $slug = $original = $page->slug ?: Str::slug($page->title);
        while (config('nova-pages.models.page')::where('id', '!=', $page->id)->where('slug', $slug)->exists())
            $slug = $original . '-' . (++$counter);
        return $slug;
    }

    /**
     * Handle the Page "saving" event.
     */
    public function saving(Page $page): void
    {
        $page->published_at = $page->published_at ?: now();
        $page->slug = $this->generateSlug($page);
        $page->author_id = $page->author_id ?: auth()->user()->id;
    }
}
