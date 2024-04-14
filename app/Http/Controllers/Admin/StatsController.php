<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Level;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StatsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $level = $request->level ?? Level::all()->first()->id;

        return Inertia::render('Admin/GameSetting/Stats', [
            'levels' => Level::all(),
            'categories' => Category::withCount([
                'questions' => function (Builder $query) use ($level) {
                    return $query->where('level_id', $level);
                },
            ])->get(),
        ]);
    }
}
