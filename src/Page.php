<?php

namespace Den1n\NovaPages;

class Page extends \Illuminate\Database\Eloquent\Model
{
    protected $guarded = [
        'id',
    ];

    protected $attributes = [
        'template' => 'default',
    ];

    protected $appends = [
        'is_published',
        'url',
    ];

    protected $dates = [
        'published_at',
    ];

    /**
     * Get the table associated with the model.
     */
    public function getTable(): string
    {
        return config('nova-pages.tables.page', parent::getTable());
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Get value of is_published attribute.
     */
    public function getIsPublishedAttribute (): bool
    {
        return now() >= $this->published_at;
    }

    /**
     * Get value of url attribute.
     */
    public function getUrlAttribute (): string
    {
        return route('nova-pages.show', [
            'page' => $this,
        ]);
    }

    /**
     * Get the author of the page.
     */
    public function author()
    {
        return $this->belongsTo(config('nova-pages.models.user'));
    }
}
