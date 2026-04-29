<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupMember extends Model
{
    use HasUuids;
    protected $fillable = [
        'group_id',
        'user_id',
        'group_role_id',
        'status',
    ];

    protected function casts(): array
    {
        return [];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function groupRole(): BelongsTo
    {
        return $this->belongsTo(GroupRole::class, 'group_role_id');
    }
}