<?php

namespace App\Http\Controllers;

use App\Events\MultiGameWinner;
use App\Events\StartMultiGame;
use App\Models\Category;
use App\Models\MultiGame;
use App\Models\MultiGameType;
use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class MultiPlayerController extends Controller
{
    private function gamerType(MultiGame $game)
    {
        $user = Auth::user();
        $gamerType = ($game->starter == $user->id) ? 'starter' : 'rival';

        return $gamerType;
    }

    private function theWinner(MultiGame $game, User $user, MultiGameType $type)
    {
        if ($game->is_active == 0) {
            if ($this->gamerType($game) == 'starter') {
                if ((int) $game->s_corrects > (int) $game->r_corrects) {
                    MultiGameWinner::dispatchIf((int) $game->s_corrects > (int) $game->r_corrects, $user, (int) $type->coin, (int) $type->point);
                } elseif ((int) $game->s_corrects == (int) $game->r_corrects) {
                    MultiGameWinner::dispatchIf((int) $game->s_corrects == (int) $game->r_corrects, $user, (int) $type->coin / 2, (int) $type->point / 2);
                }
            } elseif ($this->gamerType($game) == 'rival') {
                if ((int) $game->s_corrects < (int) $game->r_corrects) {
                    MultiGameWinner::dispatchIf((int) $game->s_corrects < (int) $game->r_corrects, $user, (int) $type->coin, (int) $type->point);
                } elseif ((int) $game->s_corrects == (int) $game->r_corrects) {
                    MultiGameWinner::dispatchIf((int) $game->s_corrects == (int) $game->r_corrects, $user, (int) $type->coin / 2, (int) $type->point / 2);
                }
            }
        }
    }

    private function foundRival($user, $type)
    {
        $available = MultiGame::where('rival', 1)->where('multi_game_type_id', $type->id)
            ->where('category_id', '!=', 6)
            ->where('is_active', 1)
            ->where('starter', '!=', $user->id)
            ->where('is_playing', 0)
            ->first();
        if ($available) {
            $available->rival = $user->id;
            $available->who_to_play = $user->id;
            $available->save();

            return redirect()->route('multi-player.play', ['game' => $available->id]);
        }
    }

    private function enoughCoins($user, $type)
    {
        if ($user->coins < $type->cost) {
            throw ValidationException::withMessages(['message' => 'سکه شما برای بازی بسیار پایین است.']);

            return redirect()->back();
        }
    }

    private function stageIncreaser(MultiGame $game)
    {
        if ($game->category_id == 6) {
            $game->stage += 1;
            if ($game->stage == 5) {
                $game->is_active = 0;
            }
        }

        $game->save();
    }

    private function saveAnswers(MultiGame $game, $answers, $corrects)
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

    private function whoToPlay(MultiGame $game)
    {
        $user = Auth::user();
        if ($game->rival == 1) {
            $game->who_to_play = 0;
        } else {
            if ($this->gamerType($game) == 'starter') {
                if ($game->prev_selector == $user->id) {
                    $game->who_to_play = $game->rival;
                } else {
                    $game->who_to_play = $game->starter;
                }
            } elseif ($this->gamerType($game) == 'rival') {
                if ($game->prev_selector == $user->id) {
                    $game->who_to_play = $game->starter;
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
        $activeGames = MultiGame::where(function ($query) use ($user) {
            $query->where('starter', $user->id)
                ->orWhere('rival', $user->id);
        })->where('is_active', 1)->get() ?? false;
        $games = MultiGame::where(function ($query) use ($user) {
            $query->where('starter', $user->id)
                ->orWhere('rival', $user->id);
        })->where('is_active', 0)->orderBy('id', 'desc')->get()->take(5) ?? false;

        return Inertia::render('MultiPlayer/Index', [
            'user' => $user,
            'activeGames' => $activeGames,
            'games' => $games,
            'normal' => MultiGameType::find(1),
            'bronze' => MultiGameType::find(2),
            'silver' => MultiGameType::find(3),
            'gold' => MultiGameType::find(4),
        ]);
    }

    public function create(MultiGameType $type)
    {
        $user = Auth::user();
        if ($user->level_id >= $type->required_level) {
            $this->enoughCoins($user, $type);

            // Event for starting a multiple game
            StartMultiGame::dispatchIf($user->coins >= $type->cost, $user, $type->cost);

            $foundRival = $this->foundRival($user, $type) ?? false;

            if ($foundRival) {
                return $foundRival;
            }

            $game = $type->multiGame()->create([
                'stage' => 0,
                'starter' => $user->id,
                'rival' => 1,
                'who_to_play' => $user->id,
                'prev_selector' => $user->id,
                'category_id' => 6,
            ]);

            return redirect()->route('multi-player.play', ['game' => $game->id]);
        }

        throw ValidationException::withMessages(['message' => 'سطح شما برای ایجاد این بازی پایین است.']);

        return redirect()->back();
    }

    public function play(MultiGame $game)
    {
        $user = Auth::user();

        return Inertia::render('MultiPlayer/Play', [
            'game' => $game,
            'gamerType' => $this->gamerType($game),
            'user' => $user,
        ]);
    }

    public function category(MultiGame $game)
    {
        return Inertia::render('MultiPlayer/Category', [
            'categories' => Category::where('slug', '!=', 'default')
                ->checkQuestions($game)
                ->get()
                ->shuffle()
                ->take(3),
            'gameId' => $game->id,
        ]);
    }

    public function categoryLoad(Request $request, MultiGame $game)
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
            ->where('status', 1)
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

        return redirect()->route('multi-player.play', ['game' => $game->id]);
    }

    public function setCategory(Request $request, MultiGame $game)
    {
        $game->category_id = $request->category ?? 6;
        $game->is_playing = 1;
        $game->prev_selector = $request->user()->id;
        $game->save();
    }

    public function setQuiz(Request $request, MultiGame $game)
    {
        $this->setCategory($request, $game);

        $questions = Category::find($game->category_id)
            ->questions()
            ->with('answers', function ($query) {
                $query->select('unique_id', 'text', 'question_id', 'is_correct')
                    ->inRandomOrder();
            })
            ->where('status', 1)
            ->setLevel($game)
            ->get()
            ->shuffle()
            ->take(3);

        return Inertia::render(
            'MultiPlayer/Quiz',
            [
                'questions' => $questions,
                'color' => $request->color,
                'time' => 15,
                'gameId' => $game->id,
            ]
        );
    }

    public function quiz(Request $request, MultiGame $game)
    {
        // Change category to default
        $game->category_id = 6;
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
                ->where('status', 1)
                ->get()
                ->shuffle()
                ->take(3);
        }

        return Inertia::render(
            'MultiPlayer/Quiz',
            [
                'questions' => $questions,
                'color' => $request->color,
                'time' => 15,
                'gameId' => $game->id,
            ]
        );
    }

    public function quizLoad(MultiGame $game)
    {
        if ($game->category_id == 6) {
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
            $this->stageIncreaser($game);
        } else {
            $questions = Category::find($game->category_id)
                ->questions()
                ->where('status', 1)
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

        $this->whoToPlay($game);
        $this->saveAnswers($game, $answers, 0);

        $game->save();

        return redirect()->route('multi-player.play', ['game' => $game->id]);
    }

    public function result(Request $request, MultiGame $game)
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
        $this->theWinner($game, $user, $type);

        $game->save();

        return redirect()->route('multi-player.play', ['game' => $game->id]);
    }
}
