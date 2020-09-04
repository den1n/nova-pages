<?php

namespace Den1n\NovaPages;

class AuthServiceProvider extends \Illuminate\Foundation\Support\Providers\AuthServiceProvider
{
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->policies = [
            config('nova-pages.models.page') => config('nova-pages.policy'),
        ];

        $this->registerPolicies();
    }
}
