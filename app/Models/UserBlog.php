<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserBlog extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'is_enabled',
        'description',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
