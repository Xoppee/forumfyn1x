<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Taggable extends Pivot
{
    protected $table = 'taggables';

    protected $fillable = [
        'tag_id',
        'taggable_id',
        'taggable_type',
    ];

    public function tag(): MorphTo
    {
        return $this->morphTo();
    }

    public function taggable(): MorphTo
    {
        return $this->morphTo();
    }
}