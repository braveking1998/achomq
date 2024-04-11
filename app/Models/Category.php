<?php

namespace App\Models;

use App\Models\MultiGameType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function scopeCheckQuestions(Builder $query, MultiGame $game): Builder
    {
        return $query->whereHas('questions', function (Builder $query) use ($game) {
            $query->where('status', 1);

            $type = $game->type()->first();
            $nextType = MultiGameType::where('id', '>', $type->id)->orderBy('id')->first() ?? false;
            if ($nextType != false) {
                $query->whereBetween('level_id', [$type->required_level, $nextType->required_level]);
            } else if ($nextType == false) {
                $query->where('level_id', '>=', $type->required_level);
            }
        }, '>=', 5);
    }
}
