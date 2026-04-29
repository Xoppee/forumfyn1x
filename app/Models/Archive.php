<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Archive extends Model
{
    protected $fillable = [
        'file_path',
        'file_name',
        'extension',
        'size',
        'archivable_id',
        'archivable_type',
    ];

    protected function casts(): array
    {
        return [
            'size' => 'integer',
        ];
    }

    public function archivable(): MorphTo
    {
        return $this->morphTo();
    }
}