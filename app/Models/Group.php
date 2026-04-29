<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Group extends Model
{
    use HasSlug, HasUuids;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_private',
        'is_verified',
        'creator_id',
    ];

    protected function casts(): array
    {
        return [
            'is_private' => 'boolean',
            'is_verified' => 'boolean',
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class);
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'group_members')
            ->withPivot(['status', 'group_role_id'])
            ->withTimestamps();
    }

    public function roles(): HasMany
    {
        return $this->hasMany(GroupRole::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function approvedMembers(): BelongsToMany
    {
        return $this->members()->wherePivot('status', 'approved');
    }

    public function checkAndUpdateVerified(): void
    {
        $hasVerifiedMember = $this->approvedMembers()
            ->where('is_verified', true)
            ->exists();

        if ($this->is_verified !== $hasVerifiedMember) {
            $this->update(['is_verified' => $hasVerifiedMember]);
        }
    }

    public function isMember(User $user): bool
    {
        return $this->members()->where('users.id', $user->id)->exists();
    }

    public function isApprovedMember(User $user): bool
    {
        return $this->members()
            ->where('users.id', $user->id)
            ->wherePivot('status', 'approved')
            ->exists();
    }

    public function isBannedMember(User $user): bool
    {
        return $this->members()
            ->where('users.id', $user->id)
            ->wherePivot('status', 'banned')
            ->exists();
    }
}