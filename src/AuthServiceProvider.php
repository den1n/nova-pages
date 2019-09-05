<?php

namespace Den1n\NovaPages;

use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends \Illuminate\Foundation\Support\Providers\AuthServiceProvider
{
    /**
     * Register any authentication / authorization services.
     */

    public function boot(): void
    {
        $this->policies = [
            config('nova-pages.model') => PagePolicy::class,
        ];

        $this->registerPolicies();

        if (class_exists('Den1n\\NovaPermissions\\ServiceProvider')) {
            foreach (['managePages', 'viewPages'] as $permission) {
                Gate::define($permission, function ($user) use ($permission) {
                    return $user->roles->contains(function ($role) use ($permission) {
                        return $role->super or in_array($permission, $role->permissions);
                    });
                });
            }
        }
    }
}
