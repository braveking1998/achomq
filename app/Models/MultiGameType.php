<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MultiGameType extends Model
{
    use HasFactory;

    protected $with = ['requiredLevel'];

    public function requiredLevel(): BelongsTo
    {
        return $this->belongsTo(Level::class, 'required_level');
    }

    public function multiGame(): HasMany
    {
        return $this->hasMany(MultiGame::class);
    }
}
