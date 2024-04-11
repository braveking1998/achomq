<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

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
