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
     * Controller class which will be serving pages.
     */

    'controller' => \Den1n\NovaPages\Controllers\Pages::class,

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
     * The group name for the Nova navigation bar in which the package resources will be displayed.
     */

    'navigation-group' => '',

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
