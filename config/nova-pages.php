<?php

return [

    /**
     * Names of models used by application.
     */

    'models' => [
        'page' => \Den1n\NovaPages\Page::class,
        'user' => config('auth.providers.users.model', \App\User::class),
    ],

    /**
     * Names of resources used by Nova.
     */

    'resources' => [
        'page' => \Den1n\NovaPages\PageResource::class,
        'user' => \App\Nova\User::class,
    ],

    /**
     * Settings of Nova field user for editing page content.
     */

    'editor' => [
        /**
         * Name of Nova field class used for editing of page content.
         */

        'class' => \Laravel\Nova\Fields\Trix::class,

        /**
         * Options which will be applied to te field instance.
         * Key: name of field method.
         * Value: list of method arguments.
         */

        'options' => [
            // 'withFiles' => ['public'],
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
