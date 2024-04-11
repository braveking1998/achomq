<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Category;
use App\Events\WrongAnswer;
use Illuminate\Http\Request;
use App\Events\CorrectAnswer;
use App\Models\SinglePlayerFeature;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class SinglePlayerController extends Controller
{
    public function index(Request $request)
    {
        // dd(Category::find($request->category)->questions()->get()->shuffle()->take(4)->toArray());
        $level = Auth::user()->level_id;

        $time = SinglePlayerFeature::where('level_id', $level)->where('feature', 'time')->first();

        $questions = Category::find($request->category)
            ->questions()
            ->with('answers', function ($query) {
                $query->select('unique_id', 'text', 'question_id', 'is_correct')
                    ->inRandomOrder();
            })
            ->where('level_id', $level)
            ->where('status', 1)
            ->get()
            ->shuffle()
            ->take(3);

        return Inertia::render(
            'SinglePlayer/Index',
            [
                'questions' => $questions,
                'color' => $request->color,
                'time' => (int) $time->value ?? 15
            ]
        );
    }

    public function category()
    {
        return Inertia::render(
            'SinglePlayer/Category',
            [
                'categories' => Category::where('slug', '!=', 'default')
                    ->whereHas('questions', function (Builder $query) {
                        $query->where('status', 1)->where('level_id', Auth::user()->level_id);
                    }, '>=', 5)
                    ->get()
                    ->shuffle()
                    ->take(3)
            ]
        );
    }

    public function result(Request $request)
    {
        $total = $request->total;
        $correct = $request->correct;
        $wrong = $total - $correct;

        $level = $request->user()->level->id;
        $win_coins = SinglePlayerFeature::where('level_id', $level)->where('feature', 'win_coins')->first();
        $lose_coins = SinglePlayerFeature::where('level_id', $level)->where('feature', 'lose_coins')->first();
        $points = SinglePlayerFeature::where('level_id', $level)->where('feature', 'points')->first();

        $earnedCoins = $correct * $win_coins->value;
        $lostCoins = $wrong * $lose_coins->value;
        $earnedPoints = $correct * $points->value;

        if ($correct > 0) {
            CorrectAnswer::dispatch($request->user(), $earnedCoins, $earnedPoints);
        }

        if ($wrong > 0) {
            WrongAnswer::dispatch($request->user(), $lostCoins);
        }

        return Inertia::render('SinglePlayer/Result', [
            'correct' => (int) $correct,
            'total' => (int) $total,
            'color' => (string) $request->color,
            'earnedCoins' => (int) $earnedCoins,
            'lostCoins' => (int) $lostCoins
        ]);
    }
}
