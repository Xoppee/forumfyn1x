<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
    use HasUuids;

    protected $fillable = [
        'path',
        'alt_text',
        'imageable_id',
        'imageable_type',
        'folder_id',
        'user_id',
        'size',
        'mime_type',
    ];

    protected function casts(): array
    {
        return [
            'size' => 'integer',
        ];
    }

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function folder(): BelongsTo
    {
        return $this->belongsTo(GalleryFolder::class, 'folder_id');
    }
}