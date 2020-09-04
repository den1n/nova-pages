<?php

return [

    /**
     * Used models.
     */

    'models' => [
        'page' => \Den1n\NovaPages\Models\Page::class,
        'user' => config('auth.providers.users.model', \App\User::class),
    ],

    /**
     * Resources used by Nova.
     */

    'resources' => [
        'page' => \Den1n\NovaPages\Resources\Page::class,
        'user' => \App\Nova\User::class,
    ],

    /**
     * Page policy used by Nova.
     */

    'policy' => \Den1n\NovaPages\Policies\Page::class,

    /**
     * Controller class which will be serving pages.
     */

    'controller' => \Den1n\NovaPages\Controller::class,

    /**
     * Names of database tables used by models.
     */

    'tables' => [
        'pages' => 'pages',
        'users' => 'users',
    ],

    /**
     * Page types.
     */

    'types' => [
        [
            'id' => 'default',
            'name' => 'Default',
        ],
    ],

    /**
     * Settings for WYSIWYG editor.
     */

    'editor' => [
        /**
         * Nova field class name.
         */

        'class' => \Laravel\Nova\Fields\Trix::class,

        /**
         * Options which will be applied to the field instance.
         * Key: name of field method.
         * Value: list of method arguments.
         */

        'options' => [
            'withFiles' => ['public', 'nova-pages'],
        ],
    ],
];
