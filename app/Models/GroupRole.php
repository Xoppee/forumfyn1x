<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GroupRole extends Model
{
    use HasUuids;
    protected $fillable = [
        'group_id',
        'name',
        'slug',
        'color',
        'level',
        'can_manage',
        'can_kick',
        'can_edit',
        'can_delete',
        'can_moderate',
    ];

    protected function casts(): array
    {
        return [
            'can_manage' => 'boolean',
            'can_kick' => 'boolean',
            'can_edit' => 'boolean',
            'can_delete' => 'boolean',
            'can_moderate' => 'boolean',
        ];
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function members(): HasMany
    {
        return $this->hasMany(GroupMember::class, 'group_role_id');
    }
}