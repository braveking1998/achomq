<?php

namespace App\Listeners;

use App\Events\AddQuestion;
use App\Events\CorrectAnswer;
use App\Events\MultiGameWinner;
use Illuminate\Events\Dispatcher;

class IncreaseEventSubscriber
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    public function increaseLevel($user)
    {
        $currentLevel = $user->level;
        $nextLevel = \App\Models\Level::where('slug', '!=', 'default')->where('id', '>', $currentLevel->id)->first();

        if ($nextLevel && $user->points > $currentLevel->max) {
            $user->points = $user->points - $currentLevel->max;
            $user->level_id = $nextLevel->id;
            $user->save();
        }

        // while($nextLevel) {
        //     if ($user->points > $currentLevel->max) {
        //         $nextLevel = 
        //     }
        // }
    }

    public function handleAddQuestion(AddQuestion $event): void
    {
        $points = $event->user->level->levelPerks->where('action', 'add_question_points')->first()->value;
        $coins = $event->user->level->levelPerks->where('action', 'add_question_coins')->first()->value;
        $event->user->points += $points;
        $event->user->coins += $coins;
        $event->user->save();

        $this->increaseLevel($event->user);
    }

    public function handleCorrectAnswer(CorrectAnswer $event): void
    {
        $event->user->coins += $event->coins; // Coins for each correct answer
        $event->user->points += $event->points; // Points for each correct answer
        $event->user->save();

        $this->increaseLevel($event->user);
    }

    public function handleMultiGameWinner(MultiGameWinner $event): void
    {
        $event->user->coins += $event->coins; // Coins for each correct answer
        $event->user->points += $event->points; // Points for each correct answer
        $event->user->save();

        $this->increaseLevel($event->user);
    }

    public function subscribe(Dispatcher $events): array
    {
        return [
            AddQuestion::class => 'handleAddQuestion',
            CorrectAnswer::class => 'handleCorrectAnswer',
            MultiGameWinner::class => 'handleMultiGameWinner',
        ];
    }
}
