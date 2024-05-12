<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SingleFeature extends Model
{
    use HasFactory;

    protected $fillable = ['level_id', 'feature', 'value'];

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }
}
