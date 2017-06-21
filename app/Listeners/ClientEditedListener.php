<?php

namespace App\Listeners;

use App\Events\ClientEdited;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ClientEditedListener
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
     * @param  ClientEdited  $event
     * @return void
     */
    public function handle(ClientEdited $event)
    {
        //
    }
}
