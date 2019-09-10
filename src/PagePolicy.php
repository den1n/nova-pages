<?php

namespace Den1n\NovaPages;

use Illuminate\Auth\Access\HandlesAuthorization;

class PagePolicy
{
    use HandlesAuthorization;

    public function before($user)
    {
        if ($user->can('pagesManager'))
            return true;
    }

    public function viewAny($user): bool
    {
        return $user->can('pagesView');
    }

    public function view($user, Page $page): bool
    {
        return $user->can('pagesView');
    }

    public function create($user): bool
    {
        return $user->can('pagesCreate');
    }

    public function update($user, Page $page): bool
    {
        return $user->can('pagesUpdate') and $user->id == $page->author_id;
    }

    public function delete($user, Page $page): bool
    {
        return $user->can('pagesDelete') and $user->id == $page->author_id;
    }

    public function restore($user, Page $page): bool
    {
        return $user->can('pagesDelete') and $user->id == $page->author_id;
    }

    public function forceDelete($user, Page $page): bool
    {
        return $user->can('pagesDelete') and $user->id == $page->author_id;
    }
}
