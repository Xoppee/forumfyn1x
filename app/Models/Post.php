<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Post extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'id',
        'body',
        'user_id',
        'topic_id',
        'moderation_reason',
        'deleted_at',
        'is_edited',
        'old_post',
        'is_hidden'
    ];

    protected function casts(): array
    {
        return [
            'is_hidden' => 'boolean',
            'is_edited' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'taggables', 'taggable_id')
            ->where('taggable_type', self::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(PostImages::class);
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