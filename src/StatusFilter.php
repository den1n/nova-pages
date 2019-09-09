<?php

namespace Den1n\NovaPages;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class StatusFilter extends \Laravel\Nova\Filters\Filter
{
    /**
     * Get the displayable name of the filter.
     */
    public function name(): string
    {
        return __('Status');
    }

    /**
     * Apply the filter to the given query.
     */
    public function apply(Request $request, $query, $value): Builder
    {
        switch ($value) {
            case 'published':
                return $query->where('published', true);
            case 'hidden':
                return $query->where('published', false);
        }
    }

    /**
     * Get the filter's available options.
     */
    public function options(Request $request): array
    {
        return [
            __('Published') => 'published',
            __('Hidden') => 'hidden',
        ];
    }
}
