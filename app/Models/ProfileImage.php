<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfileImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_path',
        'type',
        'user_id',
    ];



    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
