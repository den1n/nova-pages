<?php

namespace Den1n\NovaPages\Filters;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class Type extends \Laravel\Nova\Filters\Filter
{
    /**
     * Get the displayable name of the filter.
     */
    public function name(): string
    {
        return __('Type');
    }

    /**
     * Apply the filter to the given query.
     */
    public function apply(Request $request, $query, $value): Builder
    {
        return $query->where('type', $value);
    }

    /**
     * Get the filter's available options.
     */
    public function options(Request $request): array
    {
        $types = [];

        foreach (config('nova-pages.types') as $type) {
            $types[__($type['name'])] = $type['id'];
        }

        return $types;
    }
}
