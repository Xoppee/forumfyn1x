<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Topic extends Model
{
    use HasUuids, SoftDeletes, HasSlug;

    protected $fillable = [
        'id',
        'title',
        'slug',
        'user_id',
        'group_id',
        'is_sticky',
        'is_locked',
        'is_published',
        'moderation_reason',
    ];

    protected function casts(): array
    {
        return [
            'is_sticky' => 'boolean',
            'is_locked' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'taggables', 'taggable_id')
            ->where('taggable_type', self::class);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function archives(): MorphMany
    {
        return $this->morphMany(Archive::class, 'archivable');
    }

    public function reactions(): MorphMany
    {
        return $this->morphMany(Reaction::class, 'reactionable');
    }
}