<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Tag extends Model
{
    use HasSlug;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function topics(): BelongsToMany
    {
        return $this->belongsToMany(Topic::class, 'taggables', 'tag_id')
            ->where('taggable_type', Topic::class);
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'taggables', 'tag_id')
            ->where('taggable_type', Post::class);
    }
}