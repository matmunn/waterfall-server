<?php

namespace App\Listeners;

use App\Events\UpdateAvailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateAvailableListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UpdateAvailable  $event
     * @return void
     */
    public function handle(UpdateAvailable $event)
    {
        //
    }
}
