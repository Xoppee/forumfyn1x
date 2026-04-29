<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, HasUuids, Notifiable;

    protected $fillable = [
        'id',
        'name',
        'username',
        'email',
        'password',
        'bio',
        'avatar',
        'banner',
        'reputation',
        'role',
        'current_level',
        'is_banned',
        'is_verified',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_banned' => 'boolean',
            'is_verified' => 'boolean',
        ];
    }

    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function reactions(): HasMany
    {
        return $this->hasMany(Reaction::class);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function avatar(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable')->where('alt_text', 'avatar');
    }

    public function archives(): MorphMany
    {
        return $this->morphMany(Archive::class, 'archivable');
    }

    public function following(): HasMany
    {
        return $this->hasMany(Follow::class, 'user_id');
    }

    public function followers(): HasMany
    {
        return $this->hasMany(Follow::class, 'target_id');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)->withPivot('assigned_at');
    }

    public function hasRole(string $slug): bool
    {
        return $this->roles()->where('slug', $slug)->exists();
    }

    public function follow(User $target): void
    {
        if ($this->id === $target->id) {
            return;
        }

        if (!Follow::where('user_id', $this->id)->where('target_id', $target->id)->exists()) {
            Follow::create([
                'user_id' => $this->id,
                'target_id' => $target->id,
            ]);
        }
    }

    public function unfollow(User $target): void
    {
        Follow::where('user_id', $this->id)->where('target_id', $target->id)->delete();
    }

    public function isFollowing(User $target): bool
    {
        return Follow::where('user_id', $this->id)->where('target_id', $target->id)->exists();
    }

    public function blog()
    {
        return $this->hasOne(UserBlog::class);
    }

    public function hasBlog(): bool
    {
        return $this->blog()->where('is_enabled', true)->exists();
    }

    public function enableBlog(string $description = null): void
    {
        $this->blog()->updateOrCreate(
            ['user_id' => $this->id],
            ['is_enabled' => true, 'description' => $description]
        );
    }

    public function disableBlog(): void
    {
        if ($this->blog) {
            $this->blog->update(['is_enabled' => false]);
        }
    }
}