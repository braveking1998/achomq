<?php

namespace App\Http\Controllers;

use App\Events\CorrectAnswer;
use App\Events\StartSinglePlayerGame;
use App\Events\WrongAnswer;
use App\Jobs\EarnHeart;
use App\Models\Category;
use App\Models\SinglePlayerFeature;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SingleController extends Controller
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
                'time' => (int) $time->value ?? 15,
            ]
        );
    }

    public function category()
    {
        $user = Auth::user();
        $canPlay = ($user->hearts) ? 'true' : 'false';
        StartSinglePlayerGame::dispatch($user);
        if ($user->hearts >= 0) {
            EarnHeart::dispatchIf($user->hearts <= 4, $user)->delay(now()->addMinutes(1));
        }
        return Inertia::render(
            'SinglePlayer/Category',
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
            'lostCoins' => (int) $lostCoins,
        ]);
    }
}
