<?php

namespace App\Listeners;

use App\Events\StartSingle;
use App\Events\WrongAnswer;
use App\Events\StartMultiGame;
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

    public function handleStartSingle(StartSingle $event): void
    {
        if ($event->user->hearts) {
            $event->user->hearts -= 1;
            $event->user->save();
        }
    }

    public function subscribe(Dispatcher $events): array
    {
        return [
            WrongAnswer::class => 'handleWrongAnswer',
            StartMultiGame::class => 'handleStartMultiGame',
            StartSingle::class => 'handleStartSingle'
        ];
    }
}
