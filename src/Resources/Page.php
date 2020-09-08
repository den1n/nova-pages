<?php

namespace Den1n\NovaPages\Resources;

use Den1n\NovaPages\Fields\Keywords;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Panel;
use Laravel\Nova\Http\Requests\NovaRequest;

class Page extends Resource
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
        'title',
        'content',
    ];

    /**
     * The relationships that should be eager loaded on index queries.
     */
    public static $with = [
        'author',
    ];

    /**
     * Get the logical group associated with the resource.
     */
    public static function group()
    {
        return config('nova-pages.navigation-group', static::$group);
    }

    /**
     * Build an "index" query for the given resource.
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->reorder(
            $request->get('orderBy') ?: 'published_at',
            $request->get('orderByDirection') ?: 'desc'
        );
    }

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            $this->makeTypesField()
                ->rules('required', 'string')
                ->displayUsingLabels()
                ->sortable(),

            new Panel(__('Content'), $this->makeContentFields()),
            new Panel(__('Search Optimization'), $this->makeSEOFields()),

            Boolean::make(__('Is Published'), 'is_published')
                ->help(__('A page is considered public when it is published and the date of publication is in the past'))
                ->hideFromDetail()
                ->hideFromIndex(),

            Boolean::make(__('Is Published'), 'is_public')
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            DateTime::make(__('Published At'), 'published_at')
                ->help(__('A date when page will be available for viewing'))
                ->rules('nullable', 'date')
                ->hideFromIndex()
                ->hideFromDetail()
                ->firstDayOfWeek(1),

            DateTime::make(__('Published At'), 'published_at')
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->sortable(),

            DateTime::make(__('Created At'), 'created_at')
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->sortable(),

            DateTime::make(__('Updated At'), 'updated_at')
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->sortable(),

            BelongsTo::make(__('Author'), 'author', config('nova-pages.resources.user'))
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->sortable(),
        ];
    }

    /**
     * Creates type selection field based on application configuration.
     */
    protected function makeTypesField(): Select
    {
        return Select::make(__('Type'), 'type')->options(function () {
            $types = [];

            foreach (config('nova-pages.types') as $type) {
                $types[$type['id']] = __($type['name']);
            }

            return $types;
        });
    }

    /**
     * Get the content fields.
     */
    protected function makeContentFields(): array
    {
        return [
            Text::make(__('Slug'), 'slug')
                ->help(__('Will be filled automatically if leave empty'))
                ->rules('nullable', 'string', 'max:255')
                ->hideFromIndex(),

            Text::make(__('Title'), 'title')
                ->rules('required', 'string', 'max:255')
                ->sortable(),

            $this->makeEditorField(__('Content'), 'content')
                ->rules('nullable', 'string'),
        ];
    }

    /**
     * Get the SEO fields.
     */
    protected function makeSEOFields(): array
    {
        return [
            Keywords::make(__('Keywords'))
                ->help(__('List of keywords separated by commas'))
                ->hideFromIndex(),

            Text::make(__('Description'), 'description')
                ->rules('nullable', 'string', 'max:255')
                ->hideFromIndex(),
        ];
    }

    /**
     * Get the URI key for the resource.
     */
    public static function uriKey(): string
    {
        return 'nova-pages';
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
        return [
            new \Den1n\NovaPages\Filters\Author,
            new \Den1n\NovaPages\Filters\Type,
            new \Den1n\NovaPages\Filters\Status,
        ];
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
        return [
            (new \Den1n\NovaPages\Actions\Publish)
                ->canRun(function ($request, $page) {
                    return $request->user()->can('update', $page);
                }),
        ];
    }
}
