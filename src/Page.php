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

    protected $appends = [
        'url',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The "booting" method of the model.
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($page) {
            $page->author_id = auth()->user()->id;
        });
    }

    /**
     * Get the table associated with the model.
     */
    public function getTable()
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
     * Get value of url attribute.
     */
    public function getUrlAttribute (): string
    {
        return route('nova-pages.show', [
            'page' => $this,
        ]);
    }

    /**
     * Set value for title attribute.
     */
    public function setTitleAttribute(string $value): void
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = $this->attributes['slug'] ?? Str::slug($value);
    }

    /**
     * Get the author of the page.
     */
    public function author()
    {
        return $this->belongsTo(config('nova-pages.models.user'));
    }
}
