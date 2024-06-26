<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Level extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'max'];

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function levelPerks(): HasMany
    {
        return $this->hasMany(LevelPerk::class);
    }

    public function singleFeatures(): HasMany
    {
        return $this->hasMany(SingleFeature::class);
    }
}
