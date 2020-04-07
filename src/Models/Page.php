<?php

namespace Den1n\NovaPages\Models;

use Illuminate\Support\Str;
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
     * The "booting" method of the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function (self $page) {
            $page->published_at = $page->published_at ?: now();
            $page->slug = static::generateSlug($page);
            $page->author_id = $page->author_id ?: auth()->user()->id;
        });
    }

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
        if ($this->exists) {
            return route('nova-pages.show', [
                'page' => $this,
            ]);
        } else
            return '';
    }

    /**
     * Generate unique page slug.
     */
    protected static function generateSlug (self $page): string
    {
        $counter = 1;
        $slug = $original = $page->slug ?: Str::slug($page->title);

        while (static::where('id', '!=', $page->id)->where('slug', $slug)->exists())
            $slug = $original . '-' . (++$counter);

        return $slug;
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
