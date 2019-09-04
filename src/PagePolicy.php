<?php

namespace Den1n\NovaPages;

use Illuminate\Auth\Access\HandlesAuthorization;

class PagePolicy
{
    use HandlesAuthorization;

    public function viewAny($user): bool
    {
        return $user->can('viewPages') or $user->can('managePages');
    }

    public function view($user): bool
    {
        return $user->can('viewPages') or $user->can('managePages');
    }

    public function create($user): bool
    {
        return $user->can('managePages');
    }

    public function update($user): bool
    {
        return $user->can('managePages');
    }

    public function delete($user): bool
    {
        return $user->can('managePages');
    }

    public function restore($user): bool
    {
        return $user->can('managePages');
    }

    public function forceDelete($user): bool
    {
        return $user->can('managePages');
    }
}
