<?php

namespace Den1n\NovaPages\Policies;

use Den1n\NovaPages\Models\Page as Model;
use Illuminate\Auth\Access\HandlesAuthorization;

class Page
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

    public function view($user, Model $page): bool
    {
        return $user->can('pagesView');
    }

    public function create($user): bool
    {
        return $user->can('pagesCreate');
    }

    public function update($user, Model $page): bool
    {
        return $user->can('pagesUpdate') and $user->id == $page->author_id;
    }

    public function delete($user, Model $page): bool
    {
        return $user->can('pagesDelete') and $user->id == $page->author_id;
    }

    public function restore($user, Model $page): bool
    {
        return $user->can('pagesDelete') and $user->id == $page->author_id;
    }

    public function forceDelete($user, Model $page): bool
    {
        return $user->can('pagesDelete') and $user->id == $page->author_id;
    }
}
