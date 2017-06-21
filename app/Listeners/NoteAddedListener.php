<?php

namespace App\Listeners;

use App\Events\NoteAdded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NoteAddedListener
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
     * @param  NoteAdded  $event
     * @return void
     */
    public function handle(NoteAdded $event)
    {
        //
    }
}
