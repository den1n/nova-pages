<?php

namespace Den1n\NovaPages;

use Laravel\Nova\Resource;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Inspheric\Fields\Url;
use Illuminate\Http\Request;

class PageResource extends Resource
{
    /**
     * The model the resource corresponds to.
     */
    public static $model = '';

    /**
     * The single value that should be used to represent the resource when being displayed.
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     */
    public static $search = [
        'slug',
        'title',
        'description',
        'content',
    ];

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            $this->makeTemplatesField()
                ->rules('required', 'string')
                ->displayUsingLabels()
                ->sortable(),

            Text::make(__('Slug'), 'slug')
                ->help(__('Will be generated automatically if leave empty'))
                ->rules('nullable', 'string')
                ->hideFromIndex()
                ->sortable(),

            Url::make(__('Title'), 'url')
                ->title(__('Open page in new window'))
                ->labelUsing(function() { return $this->title; })
                ->clickable()
                ->clickableOnIndex()
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            Text::make(__('Title'), 'title')
                ->rules('required', 'string')
                ->hideFromIndex()
                ->hideFromDetail()
                ->sortable(),

            Text::make(__('Keywords'), 'keywords')
                ->help(__('List of keywords separated by commas'))
                ->rules('nullable', 'string')
                ->hideFromIndex(),

            Text::make(__('Description'), 'description')
                ->rules('nullable', 'string'),

            Boolean::make(__('Published'), 'published')
                ->rules('required')
                ->sortable(),

            $this->makeEditorField()
                ->rules('nullable', 'string')
                ->hideFromIndex()
                ->sortable(),
        ];
    }

    /**
     * Creates template selection field based on application configuration.
     */
    protected function makeTemplatesField(): Select
    {
        return Select::make(__('Template'), 'template')->options(function() {
            $templates = [];
            foreach (config('nova-pages.controller.templates') as $template)
                $templates[$template['name']] = __($template['description']);
            return $templates;
        });
    }

    /**
     * Creates field for edit content of resource based on application configuration.
     */
    protected function makeEditorField(): \Laravel\Nova\Fields\Field
    {
        $class = config('nova-pages.editor.class');
        $field = $class::make(__('Content'), 'content');
        foreach (config('nova-pages.editor.options') as $method => $arguments) {
            if (method_exists($field, $method))
                $field->{$method}(...$arguments);
        }
        return $field;
    }

    /**
     * Get the URI key for the resource.
     */
    public static function uriKey(): string
    {
        return 'pages';
    }

    /**
     * Get the displayable label of the resource.
     */
    public static function label(): string
    {
        return __('Pages');
    }

    /**
     * Get the displayable singular label of the resource.
     */
    public static function singularLabel(): string
    {
        return __('Page');
    }

    /**
     * Get the cards available for the request.
     */
    public function cards(Request $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     */
    public function filters(Request $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     */
    public function lenses(Request $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     */
    public function actions(Request $request): array
    {
        return [];
    }
}
