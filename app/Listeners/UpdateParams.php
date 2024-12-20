<?php

namespace App\Listeners;

use App\Events\ParamsProcessed;
use App\Models\Master\Parameter\MasterParameter;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateParams
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
    public function handle(ParamsProcessed $event): void
    {
        //
        Event::listen(ParamsProcessed::class, function () {
            app()->singleton('params', function () {
                return MasterParameter::first()->toArray();
            });
        });
    }
}
