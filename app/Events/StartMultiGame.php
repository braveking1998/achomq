<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StartMultiGame
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;

    public $coins;

    public function __construct(User $user, $coins)
    {
        $this->user = $user;
        $this->coins = $coins;
    }
}
