<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Follow extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'target_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function target(): BelongsTo
    {
        return $this->belongsTo(User::class, 'target_id');
    }

    public static function hasFollower(User $user, User $target): bool
    {
        return self::where('user_id', $user->id)
            ->where('target_id', $target->id)
            ->exists();
    }
}