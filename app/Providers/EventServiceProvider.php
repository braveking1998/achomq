<?php

namespace App\Providers;

use App\Events\AddHeart;
use App\Events\StartSinglePlayerGame;
use App\Listeners\DecreaseEventSubscriber;
use App\Listeners\DecreaseHeart;
use App\Listeners\EarnHeart;
use App\Listeners\IncreaseEventSubscriber;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        StartSinglePlayerGame::class => [
            DecreaseHeart::class
        ]
    ];

    protected $subscribe = [
        IncreaseEventSubscriber::class,
        DecreaseEventSubscriber::class,
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
