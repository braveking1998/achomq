<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['unique_id', 'text', 'status', 'level_id', 'category_id', 'user_id'];

    protected $with = ['answers', 'level', 'category'];

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query->when(
            $filters['category'] ?? false,
            fn ($query, $value) => $query->where('category_id', '=', $value)
        )->when(
            $filters['level'] ?? false,
            fn ($query, $value) => $query->where('level_id', '=', $value)
        )->when(
            $filters['text'] ?? false,
            fn ($query, $value) => $query->where('text', 'like', '%' . $value . '%')
        );
    }

    public function scopeUserRestrict(Builder $query): Builder
    {
        return $query->when(
            auth()->user()->is_admin != 1,
            fn ($query) => $query->where('user_id', auth()->user()->id)
        );
    }

    public function scopeMostRecent(Builder $query): Builder
    {
        return $query->orderByDesc('created_at');
    }

    public function scopeSetLevel(Builder $query, MultiGame $game): Builder
    {
        $type = $game->type()->first();
        $nextType = MultiGameType::where('id', '>', $type->id)->orderBy('id')->first() ?? false;
        if ($nextType != false) {
            return $query->whereBetween('level_id', [$type->required_level, $nextType->required_level]);
        } else if ($nextType == false) {
            return $query->where('level_id', '>=', $type->required_level);
        }
    }
}
