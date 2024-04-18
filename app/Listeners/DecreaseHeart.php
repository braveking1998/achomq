<?php

namespace App\Listeners;

use App\Events\StartSinglePlayerGame;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DecreaseHeart
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(StartSinglePlayerGame $event): void
    {
        if ($event->user->hearts) {
            $event->user->hearts -= 1;
            $event->user->save();
        }
    }
}
