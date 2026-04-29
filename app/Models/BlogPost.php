<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class BlogPost extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'id',
        'user_id',
        'template_id',
        'title',
        'slug',
        'content',
        'summary',
        'meta_fields',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'meta_fields' => 'array',
            'is_published' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getSlugOptions(): \Spatie\Sluggable\SlugOptions
    {
        return \Spatie\Sluggable\SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }
}
