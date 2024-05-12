<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MultiType extends Model
{
    use HasFactory;

    public function minLevel(): BelongsTo
    {
        return $this->belongsTo(Level::class, 'min_level');
    }

    public function multi(): HasMany
    {
        return $this->hasMany(Multi::class);
    }
}
