<?php

namespace App\Listeners;

use App\Events\NoteDeleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NoteDeletedListener
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
     * @param  NoteDeleted  $event
     * @return void
     */
    public function handle(NoteDeleted $event)
    {
        //
    }
}
