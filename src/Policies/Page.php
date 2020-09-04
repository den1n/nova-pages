<?php

namespace Den1n\NovaPages\Policies;

use Den1n\NovaPages\Models\Page as Model;
use Illuminate\Auth\Access\HandlesAuthorization;

class Page
{
    use HandlesAuthorization;

    public function viewAny($user): bool
    {
        return true;
    }

    public function view($user, Model $page): bool
    {
        return $user->id == $page->author_id or $page->is_published;
    }

    public function create($user): bool
    {
        return true;
    }

    public function update($user, Model $page): bool
    {
        return $user->id == $page->author_id;
    }

    public function delete($user, Model $page): bool
    {
        return $user->id == $page->author_id;
    }

    public function restore($user, Model $page): bool
    {
        return $user->id == $page->author_id;
    }

    public function forceDelete($user, Model $page): bool
    {
        return $user->id == $page->author_id;
    }
}
