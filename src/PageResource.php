<?php

namespace Den1n\NovaPages;

use Laravel\Nova\Resource;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Illuminate\Support\Facades\Gate;
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
    public static $title = 'name';

    /**
     * The columns that should be searched.
     */
    public static $search = [
        'name',
        'description',
    ];

    /**
     * The relationships that should be eager loaded on index queries.
     */
    public static $with = [
        'users',
    ];

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make(__('Slug'), 'slug')
                ->rules('required', 'string')
                ->showOnDetail()
                ->showOnIndex()
                ->sortable(),

            Text::make(__('Title'), 'title')
                ->rules('required', 'string')
                ->sortable(),

            Text::make(__('Keywords'), 'keywords')
                ->rules('nullable', 'string')
                ->sortable(),

            Text::make(__('Description'), 'description')
                ->rules('nullable', 'string')
                ->sortable(),

            Text::make(__('Content'), 'content')
                ->rules('nullable', 'string')
                ->sortable(),

            Boolean::make(__('Published'), 'published')
                ->rules('required')
                ->sortable(),
        ];
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
