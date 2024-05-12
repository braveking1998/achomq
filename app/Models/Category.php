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
            $query->where('status', 1);

            $type = $game->type()->first();
            $nextType = MultiType::where('id', '>', $type->id)->orderBy('id')->first() ?? false;
            if ($nextType != false) {
                $query->whereBetween('level_id', [$type->required_level, $nextType->required_level]);
            } elseif ($nextType == false) {
                $query->where('level_id', '>=', $type->required_level);
            }
        }, '>=', 5);
    }
}
