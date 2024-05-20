<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProfileImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_path',
        'type',
        'user_id',
    ];

    protected $appends = ['src'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function src(): Attribute
    {
        return Attribute::make(
            get: fn () => asset('storage/' . $this->file_path),
        );
    }
}
