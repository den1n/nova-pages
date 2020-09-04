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
            config('nova-pages.models.page') => Policies\Page::class,
        ];

        $this->registerPolicies();
    }
}
