<?php

namespace App\Listeners;

use App\Events\StartMultiGame;
use App\Events\WrongAnswer;
use Illuminate\Events\Dispatcher;

class DecreaseEventSubscriber
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    public function handleWrongAnswer(WrongAnswer $event): void
    {
        $resultedCoins = $event->user->coins - $event->coins;
        if ($resultedCoins >= 0) {
            $event->user->coins = $resultedCoins;
            $event->user->save();
        } else {
            $event->user->coins = 0;
            $event->user->save();
        }
    }

    public function handleStartMultiGame(StartMultiGame $event): void
    {
        $resultedCoins = $event->user->coins - $event->coins;
        if ($resultedCoins >= 0) {
            $event->user->coins = $resultedCoins;
            $event->user->save();
        }
    }

    public function subscribe(Dispatcher $events): array
    {
        return [
            WrongAnswer::class => 'handleWrongAnswer',
            StartMultiGame::class => 'handleStartMultiGame',
        ];
    }
}
