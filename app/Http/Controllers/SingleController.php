<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Jobs\EarnHeart;
use App\Models\Category;
use App\Events\StartSingle;
use App\Events\WrongAnswer;
use Illuminate\Http\Request;
use App\Events\CorrectAnswer;
use App\Models\SingleFeature;
use App\Models\SinglePlayerFeature;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class SingleController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $canPlay = ($user->hearts) ? 'true' : 'false';

        // Decrease hearts
        StartSingle::dispatch($user);

        // Earn hearts
        if ($user->hearts >= 0) {
            EarnHeart::dispatchIf($user->hearts <= 4, $user)->delay(now()->addMinutes(1));
        }

        return Inertia::render(
            'Single/Index',
            [
                'categories' => Category::where('slug', '!=', 'default')
                    ->whereHas('questions', function (Builder $query) {
                        $query->where('status', 1)->where('level_id', Auth::user()->level_id);
                    }, '>=', 5)
                    ->get()
                    ->shuffle()
                    ->take(3),
                'canPlay' => $canPlay
            ]
        );
    }

    public function quiz(Request $request)
    {
        $level = Auth::user()->level_id;

        $time = SingleFeature::where('level_id', $level)->where('feature', 'time')->first();

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
            'Single/Quiz',
            [
                'questions' => $questions,
                'color' => $request->color,
                'time' => (int) $time->value ?? 15,
            ]
        );
    }

    public function result(Request $request)
    {
        $total = $request->total;
        $correct = $request->correct;
        $wrong = $total - $correct;

        $level = $request->user()->level->id;
        $win_coins = SingleFeature::where('level_id', $level)->where('feature', 'win_coins')->first() ?? 10;
        $lose_coins = SingleFeature::where('level_id', $level)->where('feature', 'lose_coins')->first() ?? 2;
        $points = SingleFeature::where('level_id', $level)->where('feature', 'points')->first() ?? 10;

        $earnedCoins = $correct * $win_coins->value;
        $lostCoins = $wrong * $lose_coins->value;
        $earnedPoints = $correct * $points->value;

        if ($correct > 0) {
            CorrectAnswer::dispatch($request->user(), $earnedCoins, $earnedPoints);
        }

        if ($wrong > 0) {
            WrongAnswer::dispatch($request->user(), $lostCoins);
        }

        return Inertia::render('Single/Result', [
            'correct' => (int) $correct,
            'total' => (int) $total,
            'color' => (string) $request->color,
            'earnedCoins' => (int) $earnedCoins,
            'lostCoins' => (int) $lostCoins,
        ]);
    }
}
