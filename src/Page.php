<?php

namespace Den1n\NovaPage;

use Cviebrock\EloquentSluggable\Sluggable;

class Page extends \Illuminate\Database\Eloquent\Model
{
    use Sluggable;

    protected $guarded = [
        'id',
    ];

    /**
     * Return the sluggable configuration array for this model.
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }
}
