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
        'type' => 'default',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'keywords' => 'array',
    ];

    protected $dates = [
        'published_at',
    ];

    protected $appends = [
        'is_public',
    ];

    /**
     * The "booting" method of the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($page) {
            $page->slug = static::generateSlug($page);
            $page->author_id = $page->author_id ?: auth()->user()->id;

            if ($page->is_published and empty($page->published_at))
                $page->published_at = now();
        });
    }

    /**
     * Get the table associated with the model.
     */
    public function getTable(): string
    {
        return config('nova-pages.tables.pages', parent::getTable());
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Get value of is_public attribute.
     */
    public function getIsPublicAttribute (): bool
    {
        return $this->is_published and $this->published_at <= now();
    }

    /**
     * Generate unique page slug.
     */
    protected static function generateSlug (self $page): string
    {
        $counter = 1;
        $slug = $original = $page->slug ?: Str::slug($page->title);

        while (static::where('id', '!=', $page->id)->where('slug', $slug)->exists()) {
            $slug = $original . '-' . (++$counter);
        }

        return $slug;
    }

    /**
     * Searchable when published only.
     */
    public function shouldBeSearchable(): bool
    {
        return $this->is_public;
    }

    /**
     * Get the indexable data array for the model.
     */
    public function toSearchableArray(): array
    {
        return [
            'title' => $this->title,
            'content' => preg_replace('/\d+/u', ' ', $this->content),
        ];
    }

    /**
     * Get the options for searching engine.
     */
    public function searchableOptions(): array
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
     * Include only published pages.
     */
    public function scopeOnlyPublished($query)
    {
        return $query->where('is_published', true)->where('published_at', '<=', now());
    }

    /**
     * Get the author of the page.
     */
    public function author()
    {
        return $this->belongsTo(config('nova-pages.models.user'));
    }
}
