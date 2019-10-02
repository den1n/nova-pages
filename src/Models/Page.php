<?php

namespace Den1n\NovaPages\Models;

use Laravel\Scout\Searchable;

class Page extends \Illuminate\Database\Eloquent\Model
{
    use Searchable;

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

    protected $casts = [
        'keywords' => 'array',
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
     * Searchable when published only.
     */
    public function shouldBeSearchable(): bool
    {
        return $this->getIsPublishedAttribute();
    }

    /**
     * Get the indexable data array for the model.
     */
    public function toSearchableArray(): array
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
        ];
    }

    /**
     * Get the options for searching engine.
     */
    public function searchableOptions()
    {
        return [
            'column' => 'ts',
            'maintain_index' => true,
            'rank' => [
                'fields' => [
                    'title' => 'A',
                    'content' => 'B',
                ],
            ],
        ];
    }

    /**
     * Get the author of the page.
     */
    public function author()
    {
        return $this->belongsTo(config('nova-pages.models.user'));
    }
}
