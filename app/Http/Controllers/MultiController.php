<?php

namespace App\Http\Controllers;

use App\Events\MultiGameWinner;
use App\Events\StartMultiGame;
use App\Models\Category;
use App\Models\Multi;
use App\Models\MultiType;
use App\Models\Question;
use App\Models\User;
use App\Notifications\MultiplayNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class MultiController extends Controller
{
    private function gamerType(Multi $game)
    {
        $user = Auth::user();
        $gamerType = ($game->starter == $user->id) ? 'starter' : 'rival';

        return $gamerType;
    }

    private function theWinner(Multi $game, MultiType $type)
    {
        $starter = User::find($game->starter);
        $rival = User::find($game->rival);

        if ($game->is_active == 0) {
            if ((int) $game->s_corrects > (int) $game->r_corrects) {
                MultiGameWinner::dispatchIf((int) $game->s_corrects > (int) $game->r_corrects, $starter, (int) $type->coins, (int) $type->points);
            } elseif ((int) $game->s_corrects < (int) $game->r_corrects) {
                MultiGameWinner::dispatchIf((int) $game->s_corrects < (int) $game->r_corrects, $rival, (int) $type->coins, (int) $type->points);
            }
        }
    }

    private function foundRival($user, $type)
    {
        $available = Multi::where('rival', 1)->where('multi_type_id', $type->id)
            ->where('category_id', '!=', 1)
            ->where('is_active', 1)
            ->where('starter', '!=', $user->id)
            ->where('is_playing', 0)
            ->first();
        if ($available) {
            $available->rival = $user->id;
            $available->who_to_play = $user->id;
            $available->save();

            return redirect()->route('multi.play', ['game' => $available->id]);
        }
    }

    private function enoughCoins($user, $type)
    {
        if ($user->coins < $type->cost) {
            throw ValidationException::withMessages(['message' => 'سکه شما برای بازی بسیار پایین است.']);

            return redirect()->back();
        }
    }

    private function stageIncreaser(Multi $game)
    {
        if ($game->category_id == 1) {
            $game->stage += 1;
            if ($game->stage == 5) {
                $game->is_active = 0;
            }
        }

        $game->save();
    }

    private function saveAnswers(Multi $game, $answers, $corrects)
    {
        if ($this->gamerType($game) == 'starter') {
            if (! empty($game->s_answers)) {
                $prev_answers = json_decode($game->s_answers, true);
                $game->s_answers = json_encode(array_merge($prev_answers, $answers));
            } else {
                $game->s_answers = json_encode($answers);
            }

            $game->s_corrects += $corrects;
        } elseif ($this->gamerType($game) == 'rival') {
            if (! empty($game->r_answers)) {
                $prev_answers = json_decode($game->r_answers, true);
                $game->r_answers = json_encode(array_merge($prev_answers, $answers));
            } else {
                $game->r_answers = json_encode($answers);
            }

            $game->r_corrects += $corrects;
        }

        $game->save();
    }

    private function whoToPlay(Multi $game)
    {
        $user = Auth::user();
        if ($game->rival == 1) {
            $game->who_to_play = 0;
        } else {
            if ($this->gamerType($game) == 'starter') {
                if ($game->prev_selector == $user->id) {
                    $game->who_to_play = $game->rival;

                    User::find($game->rival)->notify(new MultiplayNotification(['id' => $game->id]));
                } else {
                    $game->who_to_play = $game->starter;
                }
            } elseif ($this->gamerType($game) == 'rival') {
                if ($game->prev_selector == $user->id) {
                    $game->who_to_play = $game->starter;

                    User::find($game->starter)->notify(new MultiplayNotification(['id' => $game->id]));
                } else {
                    $game->who_to_play = $game->rival;
                }
            }
        }

        $game->save();
    }

    public function index()
    {
        $user = Auth::user();
        $activeGames = Multi::where(function ($query) use ($user) {
            $query->where('starter', $user->id)
                ->orWhere('rival', $user->id);
        })->where('is_active', 1)->get() ?? false;
        $games = Multi::where(function ($query) use ($user) {
            $query->where('starter', $user->id)
                ->orWhere('rival', $user->id);
        })->where('is_active', 0)->orderBy('id', 'desc')->get()->take(5) ?? false;

        return Inertia::render('Multi/Index', [
            'user' => $user,
            'activeGames' => $activeGames,
            'games' => $games,
            'types' => MultiType::with('minLevel')->get(),
        ]);
    }

    public function create(MultiType $type)
    {
        $user = Auth::user();
        if ($user->level_id >= $type->min_level) {
            $this->enoughCoins($user, $type);

            // Event for starting a multiple game
            StartMultiGame::dispatchIf($user->coins >= $type->cost, $user, $type->cost);

            $foundRival = $this->foundRival($user, $type) ?? false;

            if ($foundRival) {
                return $foundRival;
            }

            $game = $type->multi()->create([
                'stage' => 0,
                'starter' => $user->id,
                'rival' => 1,
                'who_to_play' => $user->id,
                'prev_selector' => $user->id,
                'category_id' => 1,
            ]);

            return redirect()->route('multi.play', ['game' => $game->id]);
        }

        throw ValidationException::withMessages(['message' => 'سطح شما برای ایجاد این بازی پایین است.']);

        return redirect()->back();
    }

    public function play(Multi $game)
    {
        $user = Auth::user();

        return Inertia::render('Multi/Play', [
            'game' => $game,
            'gamerType' => $this->gamerType($game),
            'user' => $user,
        ]);
    }

    public function category(Multi $game)
    {
        return Inertia::render('Multi/Category', [
            'categories' => Category::where('slug', '!=', 'default')
                ->checkQuestions($game)
                ->get()
                ->shuffle()
                ->take(3),
            'gameId' => $game->id,
        ]);
    }

    public function categoryLoad(Request $request, Multi $game)
    {
        $category = Category::where('slug', '!=', 'default')
            ->checkQuestions($game)
            ->get()
            ->shuffle()
            ->take(1)
            ->first();

        $game->category_id = $category->id;

        $game->prev_selector = $request->user()->id;

        $questions = Category::find($category->id)
            ->questions()
            ->where('status', 2)
            ->setLevel($game)
            ->get()
            ->shuffle()
            ->take(3);

        $initial_answers = [];
        foreach ($questions as $question) {
            $initial_answers[] = [
                'q_id' => $question->id,
                'is_correct' => 0,
            ];
        }

        $answers = [];
        foreach ($initial_answers as $answer) {
            $answers[$game->stage][] = $answer;
        }

        $this->whoToPlay($game);
        $this->saveAnswers($game, $answers, 0);

        $game->save();

        return redirect()->route('multi.play', ['game' => $game->id]);
    }

    public function setCategory(Request $request, Multi $game)
    {
        $game->category_id = $request->category ?? 1;
        $game->is_playing = 1;
        $game->prev_selector = $request->user()->id;
        $game->save();
    }

    public function setQuiz(Request $request, Multi $game)
    {
        $this->setCategory($request, $game);

        $questions = Category::find($game->category_id)
            ->questions()
            ->with('answers', function ($query) {
                $query->select('unique_id', 'text', 'question_id', 'is_correct')
                    ->inRandomOrder();
            })
            ->where('status', 2)
            ->setLevel($game)
            ->get()
            ->shuffle()
            ->take(3);

        return Inertia::render(
            'Multi/Quiz',
            [
                'questions' => $questions,
                'color' => $request->color,
                'time' => 15,
                'gameId' => $game->id,
            ]
        );
    }

    public function quiz(Request $request, Multi $game)
    {
        // Change category to default
        $game->category_id = 1;
        $game->is_playing = 1;
        $game->save();

        $s_answers = json_decode($game->s_answers, true);
        $r_answers = json_decode($game->r_answers, true);

        if (isset($s_answers[$game->stage])) {
            $ids = [];
            foreach ($s_answers[$game->stage] as $question) {
                $ids[] = $question['q_id'];
            }
            $questions = Question::whereIn('id', $ids)->with('answers', function ($query) {
                $query->select('unique_id', 'text', 'question_id', 'is_correct')
                    ->inRandomOrder();
            })->get();
        } elseif (isset($r_answers[$game->stage])) {
            $ids = [];
            foreach ($r_answers[$game->stage] as $question) {
                $ids[] = $question['q_id'];
            }
            $questions = Question::whereIn('id', $ids)->with('answers', function ($query) {
                $query->select('unique_id', 'text', 'question_id', 'is_correct')
                    ->inRandomOrder();
            })->get();
        } else {
            $questions = Category::find($game->category_id)
                ->questions()
                ->with('answers', function ($query) {
                    $query->select('unique_id', 'text', 'question_id', 'is_correct')
                        ->inRandomOrder();
                })
                ->where('status', 2)
                ->setLevel($game)
                ->get()
                ->shuffle()
                ->take(3);
        }

        return Inertia::render(
            'Multi/Quiz',
            [
                'questions' => $questions,
                'color' => $request->color,
                'time' => 15,
                'gameId' => $game->id,
            ]
        );
    }

    public function quizLoad(Multi $game)
    {
        if ($game->category_id == 1) {
            $answers[$game->stage] = [
                [
                    'q_id' => 1,
                    'is_correct' => 0,
                ],
                [
                    'q_id' => 2,
                    'is_correct' => 0,
                ],
                [
                    'q_id' => 3,
                    'is_correct' => 0,
                ],
            ];
        } else {
            $questions = Category::find($game->category_id)
                ->questions()
                ->where('status', 2)
                ->setLevel($game)
                ->get()
                ->shuffle()
                ->take(3);

            $initial_answers = [];
            foreach ($questions as $question) {
                $initial_answers[] = [
                    'q_id' => $question->id,
                    'is_correct' => 0,
                ];
            }

            $answers = [];
            foreach ($initial_answers as $answer) {
                $answers[$game->stage][] = $answer;
            }
        }

        $game->is_playing = 0;

        $this->stageIncreaser($game);
        $this->whoToPlay($game);
        $this->saveAnswers($game, $answers, 0);
        $this->theWinner($game, $game->type()->first());

        $game->save();

        return redirect()->route('multi.play', ['game' => $game->id]);
    }

    public function result(Request $request, Multi $game)
    {
        $user = Auth::user();
        $type = $game->type()->first();
        // Update database
        $answers = [];
        foreach ($request->answers as $answer) {
            $answers[$game->stage][] = $answer;
        }

        $game->is_playing = 0;

        $this->stageIncreaser($game);
        $this->whoToPlay($game);
        $this->saveAnswers($game, $answers, $request->corrects);
        $this->theWinner($game, $type);

        $game->save();

        return redirect()->route('multi.play', ['game' => $game->id]);
    }
}
