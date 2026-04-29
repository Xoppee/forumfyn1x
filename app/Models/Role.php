<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Role extends Model
{
    use HasUuids;

    protected $fillable = [
        'id',
        'name',
        'slug',
        'icon',
        'is_active',
        'permissions'
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'permissions' => 'array',
        ];
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('assigned_at');
    }
}