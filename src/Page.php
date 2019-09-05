<?php

namespace Den1n\NovaPages;

use Illuminate\Support\Str;

class Page extends \Illuminate\Database\Eloquent\Model
{
    protected $guarded = [
        'id',
    ];

    protected $attributes = [
        'template' => 'default',
        'published' => true,
    ];

    /**
     * Set value for title attribute.
     */

    public function setTitleAttribute(string $value): void
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = $this->attributes['slug'] ?? Str::slug($value);
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
