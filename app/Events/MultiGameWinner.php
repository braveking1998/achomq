<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MultiGameWinner
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;

    public $coins;

    public $points;

    public function __construct(User $user, $coins, $points)
    {
        $this->user = $user;
        $this->coins = $coins;
        $this->points = $points;
    }
}
