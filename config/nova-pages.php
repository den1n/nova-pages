<?php

return [

    /**
     * Names of models used by application.
     */

    'models' => [
        'page' => \Den1n\NovaPages\Models\Page::class,
        'user' => config('auth.providers.users.model', \App\User::class),
    ],

    /**
     * Names of resources used by Nova.
     */

    'resources' => [
        'page' => \Den1n\NovaPages\Resources\Page::class,
        'user' => \App\Nova\User::class,
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

    /**
     * Names of database tables used by models.
     */

    'tables' => [
        'pages' => 'pages',
        'users' => 'users',
    ],

    /**
     * Settings of pages controller
     */

    'controller' => [
        /**
         * Controller class which will be serving pages.
         */

        'class' => \Den1n\NovaPages\PageController::class,

        /**
         * Array of templates used by controller.
         */

        'templates' => [
            [
                'name' => 'default',
                'description' => 'Default',
            ],
        ],
    ],
];
