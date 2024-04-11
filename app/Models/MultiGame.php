<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MultiGame extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'stage',
        'starter',
        'rival',
        'questions',
        's_answers',
        'r_answers',
        'who_to_play',
        'prev_selector',
        'category_id',
        's_corrects',
        'r_corrects'
    ];

    protected $with = ['starter', 'rival'];

    public function starter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'starter');
    }

    public function rival(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rival');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(MultiGameType::class, 'multi_game_type_id');
    }
}
