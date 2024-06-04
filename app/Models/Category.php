<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function scopeCheckQuestions(Builder $query, Multi $game): Builder
    {
        return $query->whereHas('questions', function (Builder $query) use ($game) {
            $query->where('status', 2);

            $type = $game->type()->first();
            $nextType = ($type) ? MultiType::where('id', '>', $type->id)->orderBy('id')->first() : false;
            if ($nextType != false) {
                $query->whereBetween('level_id', [$type->min_level, $nextType->min_level]);
            } elseif ($nextType == false) {
                $query->where('level_id', '>=', $type->min_level);
            }
        }, '>=', 3);
    }
}
