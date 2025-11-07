<?php

namespace App\Providers;

use App\Domains\Order\Domain\Events\OrderPlacedEvent;
use App\Domains\Order\Infrastructure\Listeners\LogOrderPlaced;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        OrderPlacedEvent::class => [
            LogOrderPlaced::class,
        ],
    ];

    public function boot()
    {
        //
    }
}