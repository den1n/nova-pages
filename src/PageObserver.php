<?php

namespace Den1n\NovaPages;

class PageObserver
{
    /**
     * Checks uniqueness of page slug.
     */
    protected function checkUniqueness (string $slug): void
    {
        if (Page::where('slug', $slug)->exists())
            throw new \Exception(__("Page with slug ':slug' already exists", ['slug' => $slug]));
    }

    /**
     * Handle the Page "creating" event.
     */
    public function creating(Page $page): void
    {
        $this->checkUniqueness($page->slug);
    }

    /**
     * Handle the Page "updating" event.
     */
    public function updating(Page $page): void
    {
        $this->checkUniqueness($page->slug);
    }
}
