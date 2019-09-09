<?php

namespace Den1n\NovaPages;

class PageObserver
{
    /**
     * Checks uniqueness of page slug.
     */
    protected function checkUniqueness (Page $page): void
    {
        $db = Page::where('slug', $page->slug)->first();
        if ($db and $db->id !== $page->id)
            throw new \Exception(__("Page with slug ':slug' already exists", ['slug' => $page->slug]));
    }

    /**
     * Handle the Page "creating" event.
     */
    public function creating(Page $page): void
    {
        $this->checkUniqueness($page);
    }

    /**
     * Handle the Page "updating" event.
     */
    public function updating(Page $page): void
    {
        $this->checkUniqueness($page);
    }
}
