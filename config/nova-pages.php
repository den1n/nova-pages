<?php

return [

    /**
     * Name of page model used by application.
     */

    'model' => \Den1n\NovaPages\Page::class,

    /**
     * Name of page resource used by Nova.
     */

    'resource' => \Den1n\NovaPages\PageResource::class,

    /**
     * Settings of Nova field user for editing page content.
     */

    'editor' => [
        /**
         * Name of Nova field class used for editing of page content.
         */

        'class' => \Laravel\Nova\Fields\Trix::class,

        /**
         * Options witch will be applied to te field instance.
         * Key: name of field method.
         * Value: list of method arguments.
         */

        'options' => [
            // 'withFiles' => ['public'],
        ],
    ],

    /**
     * Name of database table where all pages will be stored.
     */

    'table' => 'pages',

    /**
     * Settings of pages controller
     */

    'controller' => [
        /**
         * Controller class witch will be serving pages.
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
