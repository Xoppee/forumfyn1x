<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserVerification extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'rejection_reason',
        'posts_count',
        'followers_count',
        'reactions_count',
    ];

    protected function casts(): array
    {
        return [];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function requirementsMet(): array
    {
        return [
            'posts' => 20,
            'followers' => 100,
            'reactions' => 800,
        ];
    }

    public function calculateStats(): void
    {
        $user = $this->user;
        
        $this->posts_count = $user->posts()->count();
        $this->followers_count = $user->followers()->count();
        $this->reactions_count = Reaction::where('user_id', $user->id)->count();
    }

    public function meetsRequirements(): bool
    {
        $requirements = self::requirementsMet();
        
        return $this->posts_count >= $requirements['posts']
            && $this->followers_count >= $requirements['followers']
            && $this->reactions_count >= $requirements['reactions'];
    }

    public function progress(): array
    {
        $requirements = self::requirementsMet();
        
        return [
            'posts' => [
                'current' => $this->posts_count,
                'required' => $requirements['posts'],
                'met' => $this->posts_count >= $requirements['posts'],
            ],
            'followers' => [
                'current' => $this->followers_count,
                'required' => $requirements['followers'],
                'met' => $this->followers_count >= $requirements['followers'],
            ],
            'reactions' => [
                'current' => $this->reactions_count,
                'required' => $requirements['reactions'],
                'met' => $this->reactions_count >= $requirements['reactions'],
            ],
            'ready' => $this->meetsRequirements(),
        ];
    }
}