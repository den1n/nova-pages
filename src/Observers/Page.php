<?php

namespace Den1n\NovaPages\Observers;

use Den1n\NovaPages\Models\Page as Model;

class Page
{
    /**
     * Generate unique page slug.
     */
    protected function generateSlug (Model $page): string
    {
        $counter = 1;
        $slug = $original = $page->slug ?: \Illuminate\Support\Str::slug($page->title);
        while (config('nova-pages.models.page')::where('id', '!=', $page->id)->where('slug', $slug)->exists())
            $slug = $original . '-' . (++$counter);
        return $slug;
    }

    /**
     * Handle the Page "saving" event.
     */
    public function saving(Model $page): void
    {
        $page->published_at = $page->published_at ?: now();
        $page->slug = $this->generateSlug($page);
        $page->author_id = $page->author_id ?: auth()->user()->id;
    }
}
